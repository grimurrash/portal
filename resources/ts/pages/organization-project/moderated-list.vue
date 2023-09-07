<script setup lang="ts">
import { Ref } from 'vue'
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'
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

const { data: queryResult } = useQuery({
  queryKey: ['organization-projects', 'moderate-list', queryKeys],
  queryFn: () => OrganizationProjectService.moderateList({
    filters: filters.value,
    options: options.value,
  }),
  keepPreviousData: true,
})

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const {isLoading, mutate: approveProject } = useMutation({
  mutationFn: (projectId: number) => OrganizationProjectService.approve(projectId),
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ['organization-projects'] })
  },
  onError: (error: AxiosResponse) => {
    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})

const projects = computed((): OrganizationProjectListItemModel[] => queryResult.value?.data.items ?? [])
const totalItemCount = computed((): number => queryResult.value?.data.total_count ?? 0)

const selectProjectId: Ref<number> = ref(0)
const isShowEditProjectDialog = ref(false)

const openEditDialog = (projectId: number) => {
  selectProjectId.value = projectId
  isShowEditProjectDialog.value = true
}

</script>

<template>
  <section>
    <OrganizationProjectEditDialog v-model:project-id="selectProjectId" v-model:is-dialog-visible="isShowEditProjectDialog"/>

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
              cols="4"
              md="6"
              lg="4">
              <OrganizationProjectCard :project="project">
                <template #actions>
                  <VBtn
                    v-if="$can('update', 'organizationProject')"
                    @click="openEditDialog(project.id)">
                    Редактировать
                  </VBtn>
                  <VBtn
                    v-if="$can('update', 'organizationProject')"
                    @click="approveProject(project.id)">
                    Согласовать
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
  action: update
  subject: organizationProject
</route>
