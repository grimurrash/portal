<script setup lang="ts">
import { Ref } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'
import { paginationMeta } from '@/utils/utils'

const options: Ref<TableOptions> = ref<TableOptions>({
  page: 1,
  itemsPerPage: 9,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

const filters: Ref<OrganizationProjectFilterDto> = ref<OrganizationProjectFilterDto>({
  status: undefined,
  startDate: undefined,
  endDate: undefined
})

const queryKeys = computed(() => {
  return {
    options: options.value,
    filters: filters.value,
  }
})

const { isLoading, data: queryResult } = useQuery({
  queryKey: ['organization-projects', 'general-list', queryKeys],
  queryFn: () => OrganizationProjectService.generalList({
    filters: filters.value,
    options: options.value,
  }),
  keepPreviousData: true,
})

const projects = computed((): OrganizationProjectListItemModel[] => queryResult.value?.data.items ?? [])
const totalItemCount = computed((): number => queryResult.value?.data.total_count ?? 0)
const isShowViewDialog = ref(false)
const selectProjectId: Ref<number> = ref(0)
const openViewDialog = (projectId: number) => {
  selectProjectId.value = projectId
  isShowViewDialog.value = true
}
</script>

<template>
  <section>
    <OrganizationProjectViewDialog
      v-if="selectProjectId > 0"
      :project-id="selectProjectId"
      v-model:is-dialog-visible="isShowViewDialog"
    />
    <VRow>
      <VCol cols="12">
        <VCard title="Фильтры" class="mb-2">
          <OrganizationProjectListFilters v-model:filters="filters"/>
          <VDivider/>
          <OrganizationProjectListTableHeader
            v-model:options="options"
          >
            <template #paginate-meta>
              {{ paginationMeta(options, totalItemCount) }}
            </template>
          </OrganizationProjectListTableHeader>
          <VProgressLinear
            indeterminate
            v-if="isLoading"
            color="primary"
          />
        </vcard>
      </vcol>
      <VCol cols="12">
        <VRow>
          <transition-group name="fade" v-for="project in projects">
            <VCol
              :key="project.id"
              cols="12"
              md="6"
              lg="4">
              <OrganizationProjectCard :project="project">
                <template #actions>
                  <VBtn
                    @click="openViewDialog(project.id)">
                    Подробнее
                  </VBtn>
                </template>
              </OrganizationProjectCard>
            </VCol>
          </transition-group>
        </VRow>
      </vcol>
      <VCol>
        <VPagination
          v-model="options.page"
          :length="Math.ceil(totalItemCount / options.itemsPerPage)"
          :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalItemCount / options.itemsPerPage)"
        />
      </VCol>
    </VROW>
  </section>
</template>

<route lang="yaml">
meta:
  action: control
  subject: organizationProject
</route>
