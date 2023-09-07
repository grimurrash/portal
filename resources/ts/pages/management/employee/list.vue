<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { useQuery } from '@tanstack/vue-query'
import type { Ref } from 'vue'
import { EmployeeService } from '@/services/management/employee.service'
import { paginationMeta } from '@/utils/utils'

const options: Ref<TableOptions> = ref<TableOptions>({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const filters: Ref<EmployeeListFilterDto> = ref<EmployeeListFilterDto>({
  gender: null,
  department_id: null,
  is_founders_representative: null,
  age_from: null,
  age_to: null,
  education_level: null
})

const headers = [
  { title: '#', key: 'id' },
  { title: 'ФИО', key: 'full_name' },
  { title: 'ОТДЕЛ', key: 'department_id' },
  { title: 'ДОЛЖНОСТЬ', key: 'work_position' },
  { title: 'Email', key: 'work_email' },
  { title: 'Телефон', key: 'work_phone' },
  // { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

const queryKeys = computed(() => {
  return {
    options: options.value,
    filters: filters.value,
  }
})

const { data: mainListQueryResult } = useQuery({
  queryKey: ['employees', 'main-list', queryKeys],
  queryFn: () => EmployeeService.list({
    filters: filters.value,
    options: options.value,
  }),
  keepPreviousData: true,
})

const items = computed((): EmployeeListItemModel[] => mainListQueryResult.value?.data.items ?? [])
const totalItemCount = computed((): number => mainListQueryResult.value?.data.total_count ?? 0)

const isImportDialogVisible = ref(false)
</script>

<template>
  <section>
    <EmployeeImportDialog v-model:is-dialog-visible="isImportDialogVisible"/>

    <VRow>
      <VCol cols="12">
        <VCard title="Фильтры" class="mb-2">
          <VCardText>
            <VRow>
<!--              <VCol-->
<!--                cols="12"-->
<!--                sm="4"-->
<!--              >-->
<!--                <ParentDepartmentSelect-->
<!--                  label="Родительский отдел"-->
<!--                  v-model="filters.department_id"-->
<!--                  is-enabled-->
<!--                />-->
<!--              </VCol>-->
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
              <TableSearchInput
                v-model="options.search"
                placeholder="Поиск по ФИО"
              />
            </div>
            <VBtn
              variant="tonal"
              color="info"
              prepend-icon="tabler-screen-share"
              @click="isImportDialogVisible = true"
            >
              Импорт
            </VBtn>
          </VCardText>
        </vcard>

        <VCard>
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="items"
            :items-length="totalItemCount"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <template #item.department_id="{ item }">
              <div class="d-flex align-center">
                <div class="d-flex flex-column">
                  <span>{{ item.raw.department_name ?? '-' }}</span>
                </div>
              </div>
            </template>


            <template #item.actions="{ item }">
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
  subject: employee
</route>
