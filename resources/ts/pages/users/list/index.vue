<script setup lang="ts">
import type { UserProperties } from '@/db/types'
import { useUserListStore } from '@/views/users/useUserListStore'
import type { Options } from '@core/types'
import { useInfiniteQuery } from '@tanstack/vue-query'
import { UserService } from '@/services/management/users/list.service'

// 👉 Store
const userListStore = useUserListStore()
const searchQuery = ref('')
const selectedRole = ref()
const selectedPermission = ref()
const totalPages = ref(1)
const totalUsers = ref(0)
const users = ref<UserProperties[]>([])
const isAddNewUserDrawerVisible = ref(false)
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
const created = () => {
  console.log(data)
}


const { isLoading, isError, data, error, isFetching, isPreviousData } = useInfiniteQuery({
  queryKey: 'index',
  queryFn: () => {
    const data = UserService.index()
    console.log(data)
    return data;
  },
  getNextPageParam: (_lastPage, allPages) => {
    const lastPage = allPages.findLast(
      (page) => page.length > 0,
    );

    const lastRecord = lastPage[lastPage.length - 1];
    return lastRecord?.date ?? "";
  },
  staleTime: Infinity,
})

watchEffect(created)

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
<!--    <VRow>-->
<!--      <VCol cols="12">-->
<!--        <VCard title="Фильтры">-->
<!--          &lt;!&ndash; 👉 Filters &ndash;&gt;-->
<!--          <VCardText>-->
<!--            <VRow>-->
<!--              &lt;!&ndash; 👉 Select Role &ndash;&gt;-->
<!--              <VCol-->
<!--                cols="12"-->
<!--                sm="4"-->
<!--              >-->
<!--                <AppSelect-->
<!--                  v-model="selectedRole"-->
<!--                  label="Роль"-->
<!--                  :items="Object.values(Role)"-->
<!--                  clearable-->
<!--                  multiple-->
<!--                  clear-icon="tabler-x"-->
<!--                />-->
<!--              </VCol>-->
<!--              &lt;!&ndash; 👉 Select Permission &ndash;&gt;-->

<!--              <VCol-->
<!--                cols="12"-->
<!--                sm="4"-->
<!--              >-->
<!--                <AppSelect-->
<!--                  v-model="selectedPermission"-->
<!--                  label="Права доступа"-->
<!--                  :items="Object.values(Permission)"-->
<!--                  clearable-->
<!--                  multiple-->
<!--                  clear-icon="tabler-x"-->
<!--                />-->
<!--              </VCol>-->
<!--            </VRow>-->
<!--          </VCardText>-->

<!--          <VDivider />-->

<!--          <VCardText class="d-flex flex-wrap py-4 gap-4">-->
<!--            <div class="me-3 d-flex gap-3">-->
<!--              <AppSelect-->
<!--                :model-value="options.itemsPerPage"-->
<!--                :items="[-->
<!--                  { value: 10, title: '10' },-->
<!--                  { value: 25, title: '25' },-->
<!--                  { value: 50, title: '50' },-->
<!--                  { value: 100, title: '100' },-->
<!--                  { value: -1, title: 'All' },-->
<!--                ]"-->
<!--                style="width: 6.25rem;"-->
<!--                @update:model-value="options.itemsPerPage = parseInt($event, 10)"-->
<!--              />-->
<!--            </div>-->
<!--            <VSpacer />-->

<!--            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">-->
<!--              &lt;!&ndash; 👉 Search  &ndash;&gt;-->
<!--              <div style="inline-size: 10rem;">-->
<!--                <AppTextField-->
<!--                  v-model="searchQuery"-->
<!--                  placeholder="Поиск"-->
<!--                  density="compact"-->
<!--                />-->
<!--              </div>-->

<!--              &lt;!&ndash; 👉 Add user button &ndash;&gt;-->
<!--              <VBtn-->
<!--                prepend-icon="tabler-plus"-->
<!--                @click="isAddNewUserDrawerVisible = true"-->
<!--              >-->
<!--                Добавить пользователя-->
<!--              </VBtn>-->
<!--            </div>-->
<!--          </VCardText>-->

<!--          <VDivider />-->

<!--          &lt;!&ndash; SECTION datatable &ndash;&gt;-->
<!--          <VDataTableServer-->
<!--            v-model:items-per-page="options.itemsPerPage"-->
<!--            v-model:page="options.page"-->
<!--            :items="users"-->
<!--            :items-length="totalUsers"-->
<!--            :headers="headers"-->
<!--            class="text-no-wrap"-->
<!--            @update:options="options = $event"-->
<!--          >-->
<!--            &lt;!&ndash; User &ndash;&gt;-->
<!--            <template #item.user="{ item }">-->
<!--              <div class="d-flex align-center">-->
<!--                <VAvatar-->
<!--                  size="34"-->
<!--                  :variant="!item.raw.avatar ? 'tonal' : undefined"-->
<!--                  :color="!item.raw.avatar ? 'primary' : undefined"-->
<!--                  class="me-3"-->
<!--                >-->
<!--                  <VImg-->
<!--                    v-if="item.raw.avatar"-->
<!--                    :src="item.raw.avatar"-->
<!--                  />-->
<!--                  <span v-else>{{ avatarText(item.raw.name) }}</span>-->
<!--                </VAvatar>-->

<!--                <div class="d-flex flex-column">-->
<!--                  <h6 class="text-base">-->
<!--                    <RouterLink-->
<!--                      :to="{ name: 'users-view-id', params: { id: item.raw.id } }"-->
<!--                      class="font-weight-medium user-list-name"-->
<!--                    >-->
<!--                      {{ item.raw.name }}-->
<!--                    </RouterLink>-->
<!--                  </h6>-->
<!--                </div>-->
<!--              </div>-->
<!--            </template>-->

<!--            &lt;!&ndash; Email &ndash;&gt;-->
<!--            <template #item.email="{ item }">-->
<!--              <div class="d-flex align-center">-->
<!--                <div class="d-flex flex-column">-->
<!--                  <span>{{ item.raw.email }}</span>-->
<!--                </div>-->
<!--              </div>-->
<!--            </template>-->

<!--            &lt;!&ndash; 👉 Role &ndash;&gt;-->
<!--            <template #item.role="{ item }">-->
<!--              <div class="d-flex align-center gap-1">-->
<!--                <VChip-->
<!--                  v-if="item.raw.mainRole"-->
<!--                  color="primary"-->
<!--                  size="small"-->
<!--                  label-->
<!--                  class="text-capitalize"-->
<!--                >-->
<!--                  <span>{{ item.raw.mainRole }}</span>-->
<!--                </VChip>-->
<!--              </div>-->
<!--            </template>-->

<!--            &lt;!&ndash; 👉 Permission &ndash;&gt;-->
<!--            <template #item.permission="{ item }">-->
<!--              <div class="d-flex align-center gap-1">-->
<!--                <VChip-->
<!--                  v-for="permission in item.raw.permission"-->
<!--                  :key="permission"-->
<!--                  color="primary"-->
<!--                  size="small"-->
<!--                  label-->
<!--                  class="text-capitalize"-->
<!--                >-->
<!--                  <span>{{ permission }}</span>-->
<!--                </VChip>-->
<!--              </div>-->
<!--            </template>-->

<!--            &lt;!&ndash; Actions &ndash;&gt;-->
<!--            <template #item.actions="{ item }">-->
<!--              <IconBtn @click="deleteUser(item.raw)">-->
<!--                <VIcon icon="tabler-trash" />-->
<!--              </IconBtn>-->

<!--              <IconBtn @click="editUser(item.raw)">-->
<!--                <VIcon icon="tabler-edit" />-->
<!--              </IconBtn>-->

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
<!--            </template>-->

<!--            &lt;!&ndash; pagination &ndash;&gt;-->
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
<!--          </VDataTableServer>-->
<!--          &lt;!&ndash; SECTION &ndash;&gt;-->
<!--        </VCard>-->

<!--        &lt;!&ndash; 👉 Add New User &ndash;&gt;-->
<!--        <AddNewUserDrawer-->
<!--          v-model:isDrawerOpen="isAddNewUserDrawerVisible"-->
<!--          @user-data="addNewUser"-->
<!--        />-->
<!--      </VCol>-->
<!--    </VRow>-->
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
