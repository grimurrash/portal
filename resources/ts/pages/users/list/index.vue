<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import type { UserProperties } from '@/db/types'
import { Permission, Role } from '@/db/enums'
import { paginationMeta } from '@/db/utils'
import AddNewUserDrawer from '@/views/users/components/list/AddNewUserDrawer.vue'
import { useUserListStore } from '@/views/users/useUserListStore'
import type { Options } from '@core/types'
import { avatarText } from '@core/utils/formatters'
import UserInfoEditingDialog from '@/views/users/components/dialogs/UserInfoEditDialog.vue'
import DeleteDialog from '@/views/users/components/dialogs/DeleteDialog.vue'

// 👉 Store
const userListStore = useUserListStore()
const searchQuery = ref('')
const selectedRole = ref()
const selectedPermission = ref()
const totalPages = ref(1)
const totalUsers = ref(0)
const users = ref<UserProperties[]>([])
const isUserInfoEditDialogVisible = ref(false)
const isUserDeleteDialogVisible = ref(false)
const selectedUser = ref()

const options = ref<Options>({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// Headers
const headers = [
  { title: 'ФИО', key: 'user' },
  { title: 'ЭЛЕКТРОННАЯ ПОЧТА', key: 'email' },
  { title: '?ПАРОЛЬ', key: 'password' },
  { title: '?ТЕЛЕФОН', key: 'tel' },
  { title: 'РОЛЬ', key: 'role', sortable: false },
  { title: 'ПРАВА ДОСТУПА', key: 'permission', sortable: false },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

// 👉 Fetching users
const fetchUsers = () => {
  userListStore.fetchUsers({
    q: searchQuery.value,
    role: selectedRole.value,
    permission: selectedPermission.value,
    options: options.value,
  }).then(response => {
    users.value = response.data.users
    totalPages.value = response.data.totalPages
    totalUsers.value = response.data.totalUsers
    options.value.page = response.data.page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchUsers)

const isAddNewUserDrawerVisible = ref(false)

// 👉 Add new user
const addNewUser = (userData: UserProperties) => {
  userListStore.addUser(userData)

  // refetch User
  fetchUsers()
}

// 👉 Delete user
const deleteUser = (user: UserProperties) => {
  isUserDeleteDialogVisible.value = true
  selectedUser.value = user
}

const deleteUserConfirm = () => {
  userListStore.deleteUser(selectedUser.value.id)

  // refetch User
  fetchUsers()
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
                  :items="Object.values(Role)"
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
                  :items="Object.values(Permission)"
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
                  <span v-else>{{ avatarText(item.raw.fullName) }}</span>
                </VAvatar>

                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <RouterLink
                      :to="{ name: 'users-view-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.fullName }}
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
                <VAvatar
                  :size="30"
                  color="primary"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    icon="tabler-user"
                  />
                </VAvatar>
                <VChip
                  v-for="role in item.raw.role"
                  :key="role"
                  color="primary"
                  size="small"
                  label
                  class="text-capitalize"
                >
                  <span>{{ role }}</span>
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

              <!--  👉 Delete user dialog -->
              <DeleteDialog
                v-model:isDialogVisible="isUserDeleteDialogVisible"
                @confirm="deleteUserConfirm"
              />

              <!--  👉 Edit user info dialog -->
              <UserInfoEditingDialog
                v-model:isDialogVisible="isUserInfoEditDialogVisible"
                :user-data="selectedUser"
              />
            </template>

            <!-- pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalUsers) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="Math.ceil(totalUsers / options.itemsPerPage)"
                  :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalUsers / options.itemsPerPage)"
                />
              </div>
            </template>
          </VDataTableServer>
          <!-- SECTION -->
        </VCard>

        <!-- 👉 Add New User -->
        <AddNewUserDrawer
          v-model:isDrawerOpen="isAddNewUserDrawerVisible"
          @user-data="addNewUser"
        />
      </vcol>
    </vrow>
  </section>
</template>

<style lang="scss">
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
