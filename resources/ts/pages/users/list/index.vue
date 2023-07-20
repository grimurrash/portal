<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import type { UserProperties } from '@/@fake-db/types'
import { paginationMeta } from '@/@fake-db/utils'
import AddNewUserDrawer from '@/views/apps/user/list/AddNewUserDrawer.vue'
import { useUserListStore } from '@/views/apps/user/useUserListStore'
import type { Options } from '@core/types'
import { avatarText } from '@core/utils/formatters'

// 👉 Store
const userListStore = useUserListStore()
const searchQuery = ref('')
const selectedRole = ref()
const selectedPlan = ref()
const selectedStatus = ref()
const totalPage = ref(1)
const totalUsers = ref(0)
const users = ref<UserProperties[]>([])

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
  { title: 'ПАРОЛЬ', key: 'password' },
  { title: 'ТЕЛЕФОН', key: 'tel' },
  { title: 'РОЛЬ', key: 'role' },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

// 👉 Fetching users
const fetchUsers = () => {
  userListStore.fetchUsers({
    q: searchQuery.value,
    status: selectedStatus.value,
    plan: selectedPlan.value,
    role: selectedRole.value,
    options: options.value,
  }).then(response => {
    users.value = response.data.users
    totalPage.value = response.data.totalPage
    totalUsers.value = response.data.totalUsers
    options.value.page = response.data.page
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchUsers)

// 👉 search filters
const roles = [
  { title: 'Директор', value: 'director' },
  { title: 'Зам. Директора', value: 'deputy_director' },
  { title: 'Начальник Управления', value: 'department_head' },
  { title: 'Зам. Начальника Управления', value: 'deputy_department_head' },
  { title: 'Специалист По Обеспечению Безопасности', value: 'security_specialist' },
  { title: 'Администратор', value: 'admin' },
  { title: 'Начальник Отдела', value: 'chief' },
  { title: 'Организатор', value: 'organizer' },
  { title: 'Сотрудник', value: 'employee' },
]

// const plans = [
//   { title: 'Basic', value: 'basic' },
//   { title: 'Company', value: 'company' },
//   { title: 'Enterprise', value: 'enterprise' },
//   { title: 'Team', value: 'team' },
// ]

// const status = [
//   { title: 'Pending', value: 'pending' },
//   { title: 'Active', value: 'active' },
//   { title: 'Inactive', value: 'inactive' },
// ]

const resolveUserRoleVariant = (role: string) => {
  const roleLowerCase = role.toLowerCase()

  if (roleLowerCase === 'admin')
    return { color: 'warning', icon: 'tabler-circle-check' }

  return { color: 'primary', icon: 'tabler-user' }
}

// const resolveUserStatusVariant = (stat: string) => {
//   const statLowerCase = stat.toLowerCase()
//   if (statLowerCase === 'pending')
//     return 'warning'
//   if (statLowerCase === 'active')
//     return 'success'
//   if (statLowerCase === 'inactive')
//     return 'secondary'
//
//   return 'primary'
// }

const isAddNewUserDrawerVisible = ref(false)

// 👉 Add new user
const addNewUser = (userData: UserProperties) => {
  userListStore.addUser(userData)

  // refetch User
  fetchUsers()
}

// 👉 List
const userListMeta = [
  // {
  //   icon: 'tabler-user',
  //   color: 'primary',
  //   title: 'Session',
  //   stats: '21,459',
  //   percentage: +29,
  //   subtitle: 'Total Users',
  // },
  // {
  //   icon: 'tabler-user-plus',
  //   color: 'error',
  //   title: 'Paid Users',
  //   stats: '4,567',
  //   percentage: +18,
  //   subtitle: 'Last week analytics',
  // },
  // {
  //   icon: 'tabler-user-check',
  //   color: 'success',
  //   title: 'Active Users',
  //   stats: '19,860',
  //   percentage: -14,
  //   subtitle: 'Last week analytics',
  // },
  // {
  //   icon: 'tabler-user-exclamation',
  //   color: 'warning',
  //   title: 'Pending Users',
  //   stats: '237',
  //   percentage: +42,
  //   subtitle: 'Last week analytics',
  // },
]

// 👉 Delete user
const deleteUser = (id: number) => {
  userListStore.deleteUser(id)

  // refetch User
  fetchUsers()
}
</script>

<template>
  <section>
    <VRow>
      <VCol
        v-for="meta in userListMeta"
        :key="meta.title"
        cols="12"
        sm="6"
        lg="3"
      >
        <VCard>
          <VCardText class="d-flex justify-space-between">
            <div>
              <span>{{ meta.title }}</span>
              <div class="d-flex align-center gap-2 my-1">
                <h6 class="text-h4">
                  {{ meta.stats }}
                </h6>
                <span :class="meta.percentage > 0 ? 'text-success' : 'text-error'">( {{
                  meta.percentage > 0 ? '+' : ''
                }} {{ meta.percentage }}%)</span>
              </div>
              <span>{{ meta.subtitle }}</span>
            </div>

            <VAvatar
              rounded
              variant="tonal"
              :color="meta.color"
              :icon="meta.icon"
            />
          </VCardText>
        </VCard>
      </VCol>

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
                  :items="roles"
                  clearable
                  clear-icon="tabler-x"
                />
              </VCol>
              <!--              &lt;!&ndash; 👉 Select Plan &ndash;&gt; -->
              <!--              <VCol -->
              <!--                cols="12" -->
              <!--                sm="4" -->
              <!--              > -->
              <!--                <AppSelect -->
              <!--                  v-model="selectedPlan" -->
              <!--                  label="Select Plan" -->
              <!--                  :items="plans" -->
              <!--                  clearable -->
              <!--                  clear-icon="tabler-x" -->
              <!--                /> -->
              <!--              </VCol> -->
              <!--              &lt;!&ndash; 👉 Select Status &ndash;&gt; -->
              <!--              <VCol -->
              <!--                cols="12" -->
              <!--                sm="4" -->
              <!--              > -->
              <!--                <AppSelect -->
              <!--                  v-model="selectedStatus" -->
              <!--                  label="Select Status" -->
              <!--                  :items="status" -->
              <!--                  clearable -->
              <!--                  clear-icon="tabler-x" -->
              <!--                /> -->
              <!--              </VCol> -->
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

              <!-- 👉 Export button -->
              <!--              <VBtn -->
              <!--                variant="tonal" -->
              <!--                color="secondary" -->
              <!--                prepend-icon="tabler-screen-share" -->
              <!--              > -->
              <!--                Экспортировать -->
              <!--              </VBtn> -->

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
                  :color="!item.raw.avatar ? resolveUserRoleVariant(item.raw.role).color : undefined"
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
                      :to="{ name: 'demo-apps-user-view-id', params: { id: item.raw.id } }"
                      class="font-weight-medium user-list-name"
                    >
                      {{ item.raw.fullName }}
                    </RouterLink>
                  </h6>

                  <span class="text-sm text-medium-emphasis">@{{ item.raw.email }}</span>
                </div>
              </div>
            </template>

            <!-- 👉 Role -->
            <template #item.role="{ item }">
              <div class="d-flex align-center gap-4">
                <VAvatar
                  :size="30"
                  :color="resolveUserRoleVariant(item.raw.role).color"
                  variant="tonal"
                >
                  <VIcon
                    :size="20"
                    :icon="resolveUserRoleVariant(item.raw.role).icon"
                  />
                </VAvatar>
                <span class="text-capitalize">{{ item.raw.role }}</span>
              </div>
            </template>

            <!-- Plan -->
            <template #item.plan="{ item }">
              <span class="text-capitalize font-weight-medium">{{ item.raw.currentPlan }}</span>
            </template>

            <!-- Status -->
            <template #item.status="{ item }">
              <VChip
                :color="resolveUserStatusVariant(item.raw.status)"
                size="small"
                label
                class="text-capitalize"
              >
                {{ item.raw.status }}
              </VChip>
            </template>

            <!-- Actions -->
            <template #item.actions="{ item }">
              <IconBtn @click="deleteUser(item.raw.id)">
                <VIcon icon="tabler-trash" />
              </IconBtn>

              <IconBtn>
                <VIcon icon="tabler-edit" />
              </IconBtn>
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
