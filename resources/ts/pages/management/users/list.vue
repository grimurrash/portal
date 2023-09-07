<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useQuery } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { PermissionNames } from '@/types/enums/permission.enum'
import { RoleNames } from '@/types/enums/role.enum'
import { paginationMeta } from '@/utils/utils'
import { avatarText } from '@core/utils/formatters'
import { objectToOptions } from '@/utils/enums'

const isAddNewUserDrawerVisible = ref(false)
const isUserInfoEditDialogVisible = ref(false)
const isUserDeleteDialogVisible = ref(false)
const selectedUser = ref<UserListItemModel>()
const deleteUserId = ref<number>()

const headers = [
  { title: 'ФИО', key: 'name' },
  { title: 'ЭЛЕКТРОННАЯ ПОЧТА', key: 'email' },
  { title: 'РОЛЬ', key: 'roles', sortable: false },
  { title: 'ПРАВА ДОСТУПА', key: 'permissions', sortable: false },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

const userListFilter = ref<UserListRequestDto>({
  options: {
    page: 1,
    itemsPerPage: 10,
    sortBy: [],
    groupBy: [],
    search: undefined,
  },
  filters: {
    role: null,
    permission: null,
  }
})

const { data: mainListQueryResult } = useQuery({
  queryKey: ['users', 'main-list', userListFilter.value],
  queryFn: () => UserService.list(userListFilter.value),
  keepPreviousData: true,
})

const users = computed((): UserListItemModel[] => mainListQueryResult.value?.data.items ?? [])
const totalUsers = computed((): number => mainListQueryResult.value?.data.total_count ?? 0)

const openDeleteUserConfirmDialog = (id: number) => {
  deleteUserId.value = id
  isUserDeleteDialogVisible.value = true
}
const openEditUserDialog = (user: UserListItemModel) => {
  selectedUser.value = user
  isUserInfoEditDialogVisible.value = true
}
const roleOptions = objectToOptions(RoleNames)
const permissionOptions = objectToOptions(PermissionNames)
</script>

<template>
  <section>

    <UserDeleteDialog
      v-model:isDialogVisible="isUserDeleteDialogVisible"
      :user-id="deleteUserId"
    />

    <UserEditDialog
      v-model:isDialogVisible="isUserInfoEditDialogVisible"
      :user-data="selectedUser"
    />

    <AddUserDrawer
      v-model:isDrawerOpen="isAddNewUserDrawerVisible"
    />

    <VRow>
      <VCol cols="12">
        <VCard title="Фильтры">
          <VCardText>
            <VRow>
              <VCol
                cols="12"
                sm="3"
              >
                <AppSelect
                  v-model="userListFilter.filters.role"
                  label="Роль"
                  :items="roleOptions"
                  clearable
                  item-value="id"
                  item-title="label"
                  clear-icon="tabler-x"
                />
              </VCol>

              <VCol
                cols="12"
                sm="3"
              >
                <AppSelect
                  v-model="userListFilter.filters.permission"
                  label="Права доступа"
                  :items="permissionOptions"
                  clearable
                  item-value="id"
                  item-title="label"
                  clear-icon="tabler-x"
                />
              </VCol>
            </VRow>
          </VCardText>

          <VDivider/>

          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="userListFilter.options.itemsPerPage"
                :items="[
                  { value: 10, title: '10' },
                  { value: 25, title: '25' },
                  { value: 50, title: '50' },
                  { value: 100, title: '100' },
                ]"
                style="width: 6.25rem;"
                @update:model-value="userListFilter.options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer/>

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <TableSearchInput
                v-model="userListFilter.options.search"
                placeholder="Поиск по имени или почте"
              />
            </div>
            <VBtn
              v-if="$can('create', 'user')"
              variant="flat"
              prepend-icon="tabler-user-plus"
              @click="isAddNewUserDrawerVisible = true"
            >
              Добавить пользователя
            </VBtn>
          </VCardText>

          <VDivider/>

          <VDataTableServer
            v-model:items-per-page="userListFilter.options.itemsPerPage"
            v-model:page="userListFilter.options.page"
            :items="users"
            :items-length="totalUsers"
            :headers="headers"
            class="text-no-wrap"
            @update:options="userListFilter.options = $event"
          >
            <template #item.name="{ item }">
              <div class="d-flex align-center">
                <VAvatar
                  size="34"
                  :variant="!item.raw.avatar ? 'tonal' : undefined"
                  :color="!item.raw.avatar ? 'primary' : undefined"
                  class="me-3"
                >
                  <VImg
                    v-if="item.raw.avatar"
                    :src="item.raw.avatar"
                  />
                  <span v-else>{{ avatarText(item.raw.name) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'management-users-view-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.name }}
                    </RouterLink>
                  </h6>
                </div>
              </div>
            </template>

            <template #item.email="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <span>{{ item.raw.email }}</span>
                </div>
              </div>
            </template>

            <template #item.roles="{ item }">
              <div class="d-flex flex-wrap my-2 align-center gap-1" style="width: 220px;">
                <VChip
                  v-for="role in item.raw.roles" :key="role"
                  color="primary"
                  variant="elevated"
                  label
                  class="text-capitalize my-1"
                >
                  <span>{{ RoleNames[role as keyof typeof RoleNames] }}</span>
                </VChip>
              </div>
            </template>

            <template #item.permissions="{ item }">
              <div class="d-flex flex-wrap my-2  align-center gap-1" style="width: 450px;">
                <VChip
                  v-for="permission in item.raw.permissions"
                  :key="permission"
                  color="primary"
                  variant="elevated"
                  label
                  class="text-capitalize my-1"
                >
                  <span>{{ PermissionNames[permission as keyof typeof PermissionNames] }}</span>
                </VChip>
              </div>
            </template>

            <template #item.actions="{ item }">
              <IconBtn v-if="$can('update', 'user')" @click="openEditUserDialog(item.raw)">
                <VIcon icon="tabler-edit"/>
              </IconBtn>
              <IconBtn v-if="$can('delete', 'user')" @click="openDeleteUserConfirmDialog(item.raw.id)">
                <VIcon icon="tabler-trash"/>
              </IconBtn>
            </template>

            <template #bottom>
              <VDivider/>
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(userListFilter.options, totalUsers) }}
                </p>

                <VPagination
                  v-model="userListFilter.options.page"
                  :length="Math.ceil(totalUsers / userListFilter.options.itemsPerPage)"
                  :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalUsers / userListFilter.options.itemsPerPage)"
                />
              </div>
            </template>
          </VDataTableServer>
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>

<style lang="scss" scoped>
.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-medium-emphasis-opacity));
}
</style>

<route lang="yaml">
meta:
action: read
subject: User
</route>
