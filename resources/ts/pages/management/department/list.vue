<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useQuery } from '@tanstack/vue-query'
import type { Ref } from 'vue'
import { DepartmentService } from '@/services/management/department.service'
import { paginationMeta } from '@/utils/utils'

const options: Ref<TableOptions> = ref<TableOptions>({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const filters: Ref<DepartmentListFilterDto> = ref<DepartmentListFilterDto>({
  parentDepartmentId: undefined,
})

const headers = [
  { title: '#', key: 'id' },
  { title: 'НАИМЕНОВАНИЕ', key: 'name' },
  { title: 'РОДИТЕЛЬСКИЙ ОТДЕЛ', key: 'parent_department_id' },
  { title: 'РУКОВОДИТЕЛЬ', key: 'head_employee_id' },
  { title: 'КОЛ-ВО СОТРУДНИКОВ', key: 'employees_count' },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

const queryKeys = computed(() => {
  return {
    options: options.value,
    filters: filters.value,
  }
})

const { data: mainListQueryResult } = useQuery({
  queryKey: ['departments', 'main-list', queryKeys],
  queryFn: () => DepartmentService.list({
    filters: filters.value,
    options: options.value,
  }),
  keepPreviousData: true,
})

const departments = computed((): DepartmentListItemModel[] => mainListQueryResult.value?.data.items ?? [])
const totalItemCount = computed((): number => mainListQueryResult.value?.data.total_count ?? 0)

const isDepartmentEditDialogVisible = ref(false)
const selectedDepartment = ref()

const editDepartment = (department: DepartmentListItemModel) => {
  selectedDepartment.value = department
  isDepartmentEditDialogVisible.value = true
}
</script>

<template>
  <section>
    <DepartmentEditDialog
      v-model:isDialogVisible="isDepartmentEditDialogVisible"
      :department-data="selectedDepartment"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Фильтры" class="mb-2">
          <VCardText>
            <VRow>
              <VCol
                cols="12"
                sm="4"
              >
                <ParentDepartmentSelect
                  label="Родительский отдел"
                  v-model="filters.parentDepartmentId"
                  is-enabled
                />
              </VCol>
            </VRow>
          </VCardText>
          <VDivider/>
          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="options.itemsPerPage"
                :items="[
                    { value: 10, title: '10' },
                    { value: 25, title: '25' },
                    { value: 50, title: '50' },
                    { value: 100, title: '100' },
                  ]"
                style="width: 6.25rem;"
                @update:model-value="options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer/>

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <div style="inline-size: 30rem;">
                <TableSearchInput
                  v-model="options.search"
                  placeholder="Поиск по наименование отдела"
                />
              </div>
            </div>
          </VCardText>
        </vcard>

        <VCard>
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="departments"
            :items-length="totalItemCount"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <template #item.parent_department_id="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <span>{{ item.raw.parent_department_name ?? '-' }}</span>
                </div>
              </div>
            </template>

            <template #item.head_employee_id="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <span>{{ item.raw.head_employee_name ?? '-' }}</span>
                </div>
              </div>
            </template>

            <template #item.actions="{ item }">
              <IconBtn
                v-if="$can('update', 'department')"
                @click="editDepartment(item.raw)"
              >
                <VIcon icon="tabler-edit"/>
              </IconBtn>
            </template>

            <template #bottom>
              <VDivider/>
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalItemCount) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="Math.ceil(totalItemCount / options.itemsPerPage)"
                  :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalItemCount / options.itemsPerPage)"
                />
              </div>
            </template>
          </VDataTableServer>
        </VCard>

      </vcol>
    </vrow>
  </section>
</template>

<style lang="scss" scoped>
.text-capitalize {
  text-transform: capitalize;
}
</style>

<route lang="yaml">
meta:
  action: read
  subject: department
</route>
