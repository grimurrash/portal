<script setup lang="ts">
import type { UserProperties } from '@/db/types'
import { useUserListStore } from '@/views/users/useUserListStore'
import { avatarText } from '@core/utils/formatters'
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useQuery } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { Ref } from 'vue'
import { UserListFilterDto } from '@/types/dto/management/users/list.dto'
import { UserListItemModel } from '@/types/model/management/user.model'
import { RoleEnum } from '@/types/enums/role.enum'
import { PermissionEnum } from '@/types/enums/permission.enum'

// 👉 Store
const userListStore = useUserListStore()
const searchQuery = ref('')
const selectedRole = ref()
const selectedPermission = ref()
const totalPages = ref(1)
const totalUsers = ref(0)
const isAddNewUserDrawerVisible = ref(false)
const isUserInfoEditDialogVisible = ref(false)
const isUserDeleteDialogVisible = ref(false)
const selectedUser = ref()

// Headers
const headers = [
  { title: 'ФИО', key: 'user' },
  { title: 'ЭЛЕКТРОННАЯ ПОЧТА', key: 'email' },
  { title: 'РОЛЬ', key: 'role', sortable: false },
  { title: 'ПРАВА ДОСТУПА', key: 'permission', sortable: false },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]
const options: Ref<TableOptions> = ref<TableOptions>({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const filters: Ref<UserListFilterDto> = ref<UserListFilterDto>({
  role: undefined,
})
const queryKeys = computed(() => {
  return {
    options: options.value,
    filters: filters.value,
  }
})

const { data: mainListQueryResult } = useQuery({
  queryKey: ['users', 'main-list', queryKeys],
  queryFn: () => UserService.list({
    filters: filters.value,
    options: options.value,
  }),
  keepPreviousData: true,
})

const users = computed((): UserListItemModel[] => mainListQueryResult.value?.data.items ?? [])
const totalItemCount = computed((): number => mainListQueryResult.value?.data.total_count ?? 0)

const check = () => {
  console.log(users)
}

// 👉 Add new user
const addNewUser = (userData: UserProperties) => {
  userListStore.addUser(userData)
}

// 👉 Delete user
const deleteUser = (user: UserProperties) => {
  isUserDeleteDialogVisible.value = true
  selectedUser.value = user
}

const deleteUserConfirm = () => {
  userListStore.deleteUser(selectedUser.value.id)
}

const editUser = (user: UserProperties) => {
  isUserInfoEditDialogVisible.value = true
  selectedUser.value = user
}
</script>

<template>
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Фильтры">
          <!-- 👉 Filters -->
          <VCardText>
            <VRow>
              <!-- 👉 Select Role -->
              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedRole"
                  label="Роль"
                  :items="Object.values(RoleEnum)"
                  clearable
                  multiple
                  clear-icon="tabler-x"
                />
              </VCol>
              <!-- 👉 Select Permission -->

              <VCol
                cols="12"
                sm="4"
              >
                <AppSelect
                  v-model="selectedPermission"
                  label="Права доступа"
                  :items="Object.values(PermissionEnum)"
                  clearable
                  multiple
                  clear-icon="tabler-x"
                />
              </VCol>
            </VRow>
          </VCardText>

          <VDivider />

          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="options.itemsPerPage"
                :items="[
                  { value: 10, title: '10' },
                  { value: 25, title: '25' },
                  { value: 50, title: '50' },
                  { value: 100, title: '100' },
                  { value: -1, title: 'All' },
                ]"
                style="width: 6.25rem;"
                @update:model-value="options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer />

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <!-- 👉 Search  -->
              <div style="inline-size: 10rem;">
                <AppTextField
                  v-model="searchQuery"
                  placeholder="Поиск"
                  density="compact"
                />
              </div>

              <!-- 👉 Add user button -->
              <VBtn
                prepend-icon="tabler-plus"
                @click="isAddNewUserDrawerVisible = true"
              >
                Добавить пользователя
              </VBtn>
              <VBtn
                prepend-icon="tabler-plus"
                @click="check"
              />
            </div>
          </VCardText>

          <VDivider />

          <!-- SECTION datatable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="users"
            :items-length="totalUsers"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- User -->
            <template #item.user="{ item }">
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

            <!-- Email -->
            <template #item.email="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <span>{{ item.raw.email }}</span>
                </div>
              </div>
            </template>

            <!-- 👉 Role -->
            <template #item.role="{ item }">
              <div class="d-flex align-center gap-1">
                <VChip
                  v-if="item.raw.role"
                  color="primary"
                  size="small"
                  label
                  class="text-capitalize"
                >
                  <span>{{ item.raw.role }}</span>
                </VChip>
              </div>
            </template>

            <!-- 👉 Permission -->
            <template #item.permission="{ item }">
              <div class="d-flex align-center gap-1">
                <VChip
                  v-for="permission in item.raw.permission"
                  :key="permission"
                  color="primary"
                  size="small"
                  label
                  class="text-capitalize"
                >
                  <span>{{ permission }}</span>
                </VChip>
              </div>
            </template>

            <!-- Actions -->
            <template #item.actions="{ item }">
              <IconBtn @click="deleteUser(item.raw)">
                <VIcon icon="tabler-trash" />
              </IconBtn>

              <IconBtn @click="editUser(item.raw)">
                <VIcon icon="tabler-edit" />
              </IconBtn>

<!--              &lt;!&ndash;  👉 Delete user dialog &ndash;&gt;-->
<!--              <DeleteDialog-->
<!--                v-model:isDialogVisible="isUserDeleteDialogVisible"-->
<!--                @confirm="deleteUserConfirm"-->
<!--              />-->

<!--              &lt;!&ndash;  👉 Edit user info dialog &ndash;&gt;-->
<!--              <UserInfoEditingDialog-->
<!--                v-model:isDialogVisible="isUserInfoEditDialogVisible"-->
<!--                :user-data="selectedUser"-->
<!--              />-->
            </template>

            <!-- pagination -->
<!--            <template #bottom>-->
<!--              <VDivider />-->
<!--              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">-->
<!--                <p class="text-sm text-disabled mb-0">-->
<!--                  {{ paginationMeta(options, totalUsers) }}-->
<!--                </p>-->

<!--                <VPagination-->
<!--                  v-model="options.page"-->
<!--                  :length="Math.ceil(totalUsers / options.itemsPerPage)"-->
<!--                  :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalUsers / options.itemsPerPage)"-->
<!--                />-->
<!--              </div>-->
<!--            </template>-->
          </VDataTableServer>
          <!-- SECTION -->
        </VCard>

<!--        &lt;!&ndash; 👉 Add New User &ndash;&gt;-->
<!--        <AddNewUserDrawer-->
<!--          v-model:isDrawerOpen="isAddNewUserDrawerVisible"-->
<!--          @user-data="addNewUser"-->
<!--        />-->
      </VCol>
    </VRow>
  </section>
</template>

<style lang="scss" scoped>
.app-user-search-filter {
  inline-size: 31.6rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-medium-emphasis-opacity));
}
</style>
