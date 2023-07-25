<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { paginationMeta } from '@/db/utils'
import type { Options } from '@core/types'
import type { DepartmentProperties } from '@/db/types'
import { useDepartmentListStore } from '@/views/departments/useDepartmentListStore'
import DepartmentInfoEditDialog from '@/views/departments/components/dialogs/DepartmentInfoEditDialog.vue'
import DepartmentsImportDialog from '@/views/departments/components/dialogs/DepartmentsImportDialog.vue'

// 👉 Store
const departmentListStore = useDepartmentListStore()
const searchQuery = ref('')
const totalPages = ref(1)
const totalDepartments = ref(0)
const departments = ref<DepartmentProperties[]>([])
const isDepartmentInfoEditDialogVisible = ref(false)
const isDepartmentsImportDialogVisible = ref(false)
const selectedDepartment = ref()

const options = ref<Options>({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// Headers
const headers = [
  { title: 'НАИМЕНОВАНИЕ', key: 'title' },
  { title: 'РОДИТЕЛЬСКИЙ ОТДЕЛ', key: 'parentalDepartment' },
  { title: 'РУКОВОДИТЕЛЬ', key: 'head' },
  { title: 'КОЛ-ВО СОТРУДНИКОВ', key: 'numberOfStaff' },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

const fetchUsers = () => {
  const response = departmentListStore.fetchDepartments({
    q: searchQuery.value,
    options: options.value,
  })

  departments.value = response.departments
  totalPages.value = response.totalPages
  totalDepartments.value = response.totalDepartments
  options.value.page = response.page
}

watchEffect(fetchUsers)

const departmentsImport = () => {
  isDepartmentsImportDialogVisible.value = true
}

const editDepartment = (department: DepartmentProperties) => {
  isDepartmentInfoEditDialogVisible.value = true
  selectedDepartment.value = department
}
</script>

<template>
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Search Filter">
          <!-- 👉 Filters -->
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
                  placeholder="Search"
                  density="compact"
                />
              </div>

              <!-- 👉 Import button -->
              <VBtn
                variant="tonal"
                color="secondary"
                prepend-icon="tabler-screen-share"
                @click="departmentsImport"
              >
                Импорт отделов
              </VBtn>

              <!--  👉 Edit user info dialog -->
              <DepartmentsImportDialog v-model:isDialogVisible="isDepartmentsImportDialogVisible" />
            </div>
          </VCardText>

          <VDivider />

          <!-- SECTION datatable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="departments"
            :items-length="totalDepartments"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- Title -->
            <template #item.title="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <span class="text-sm text-medium-emphasis">{{ item.raw.title }}</span>
                  </h6>
                </div>
              </div>
            </template>

            <!-- Parental Department -->
            <template #item.parental-department="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <span class="text-sm text-medium-emphasis">{{ item.raw.parentalDepartment }}</span>
                  </h6>
                </div>
              </div>
            </template>

            <!-- Head -->
            <template #item.head="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <span class="text-sm text-medium-emphasis">{{ item.raw.head }}</span>
                  </h6>
                </div>
              </div>
            </template>

            <!-- numberOfStaff -->
            <template #item.number-of-staff="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <h6 class="text-base">
                    <span class="text-sm text-medium-emphasis">{{ item.raw.numberOfStaff }}</span>
                  </h6>
                </div>
              </div>
            </template>

            <!-- Actions -->
            <template #item.actions="{ item }">
              <IconBtn @click="editDepartment(item.raw)">
                <VIcon icon="tabler-edit" />
              </IconBtn>

              <!--  👉 Edit user info dialog -->
              <DepartmentInfoEditDialog
                v-model:isDialogVisible="isDepartmentInfoEditDialogVisible"
                :department-data="selectedDepartment"
                :departments="departments.map(d => d.title)"
              />
            </template>

            <!-- pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalDepartments) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="Math.ceil(totalDepartments / options.itemsPerPage)"
                  :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalDepartments / options.itemsPerPage)"
                />
              </div>
            </template>
          </VDataTableServer>
          <!-- SECTION -->
        </VCard>
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
