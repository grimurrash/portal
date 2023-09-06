<script setup lang="ts">
import { Ref } from 'vue'
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'
import { useAuthStore } from '@/store/useAuthStore'
import { OrganizationProjectStatusEnum } from '@/types/enums/organization-project-status.enum'
import { AxiosResponse } from 'axios'
import { paginationMeta } from '@/utils/utils'

const authStore = useAuthStore()
const userData = authStore.getUserData()
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
  queryKey: ['organization-projects', 'main-list', queryKeys],
  queryFn: () => OrganizationProjectService.mainList({
    filters: filters.value,
    options: options.value,
  }),
  keepPreviousData: true,
})

const queryClient = useQueryClient()

const globalError = ref()
const isSnackbarVisible = ref(false)

const { mutate: sendToModerate } = useMutation({
  mutationFn: (id: number) => OrganizationProjectService.postForModeration(id),
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ['organization-projects'] })
  },
  onError: (error: AxiosResponse) => {
    globalError.value = (error.data as BaseAxiosErrorResponse).message
    isSnackbarVisible.value = true
  },
})

const projects = computed((): OrganizationProjectListItemModel[] => queryResult.value?.data.items ?? [])
const totalItemCount = computed((): number => queryResult.value?.data.total_count ?? 0)
const isShowAddNewProjectDialog = ref(false)
</script>

<template>
  <section>
    <OrganizationProjectAddNewDialog v-model:is-dialog-visible="isShowAddNewProjectDialog"/>

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
            <template #actions>
              <VBtn
                v-if="$can('create', 'organizationProject')"
                prepend-icon="tabler-plus"
                @click="isShowAddNewProjectDialog = true"
              >
                Добавить проект
              </VBtn>
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
                    v-if="project.status === OrganizationProjectStatusEnum.CREATE && project.organizer_user_id === userData.id"
                    @click="sendToModerate(project.id)">
                    На модерацию
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
    <VSnackbar
      v-model="isSnackbarVisible"
      transition="scale-transition"
      location="top end"
      variant="flat"
      color="error"
      :timeout="2000"
    >
      {{ globalError }}
    </VSnackbar>
  </section>
</template>

<route lang="yaml">
meta:
  action: read
  subject: organizationProject
</route>