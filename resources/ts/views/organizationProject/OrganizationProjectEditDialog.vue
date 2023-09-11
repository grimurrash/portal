<script setup lang="ts">
import type { Ref } from 'vue'
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'

defineOptions({
  name: 'OrganizationProjectEditDialog',
})

interface Props {
  projectId: number
  isDialogVisible: boolean
}

interface Emit {
  (e: 'update:isDialogVisible', val: boolean): void
}

const emptyProject: UpdateOrganizationProjectRequestDto = {
  id: 0,
  number: 0,
  name: '',
  description: '',
  start_date: new Date(),
  end_date: new Date(),
  dates: [],
  metrics: '',
  planned_coverage: 0,
  actual_coverage: 0,
  responsible_user_id: 0,
  curator_user_id: 0
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const projectData: Ref<UpdateOrganizationProjectRequestDto> = ref<UpdateOrganizationProjectRequestDto>(emptyProject)

const { refetch: fetchProfileInfo, isLoading, isSuccess, data: projectInfoResult } = useQuery({
  queryKey: ['organization-projects', 'show', props.projectId],
  queryFn: () => OrganizationProjectService.showProject(props.projectId),
  keepPreviousData: true,
  staleTime: 1000 * 60,
  enabled: props.projectId !== 0
})

watch(props, () => {
  if (projectData.value.id !== props.projectId) {
    fetchProfileInfo()
  }
})

watch(projectInfoResult, () => {
  if (projectInfoResult.value?.data.id !== projectData.value.id) {
    projectData.value = structuredClone(toRaw(projectInfoResult.value?.data)) as UpdateOrganizationProjectRequestDto
  }
})

const errors = ref<Record<string, string>>({})

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const { mutate: moderateProject } = useMutation({
  mutationFn: (projectData: UpdateOrganizationProjectRequestDto) => OrganizationProjectService.moderate(projectData),
  onSuccess: () => {
    dialogModelValueUpdate(false)
    queryClient.invalidateQueries({ queryKey: ['organization-projects'] })
  },
  onError: (error: AxiosResponse) => {
    if (error.status === 422) {
      errors.value = (error.data as UnprocessableErrorResponse).errors
    }

    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})

const onFormSubmit = () => {
  errors.value = {}
  refForm.value?.validate()
  .then(() => moderateProject(projectData.value))
}

const onFormReset = () => {
  dialogModelValueUpdate(false)
}

const refForm = ref<OrganizationProjectForm>()
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 677"
    :model-value="props.isDialogVisible"
    persistent
    @update:model-value="dialogModelValueUpdate"
    scrollable
  >
    <VProgressCircular
      v-if="isLoading"
      :size="60"
      color="warning"
      indeterminate
      style="position: absolute; left: 50%;"
    />
    <DialogCloseBtn v-show="isSuccess" @click="dialogModelValueUpdate(false)"/>
    <VCard v-show="isSuccess" title="Редактирование проекта">
      <VCardText>
        <OrganizationProjectForm v-model:project-data="projectData" :errors="errors" @submit="onFormSubmit()" ref="refForm"/>
      </VCardText>
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            class="d-flex flex-wrap justify-center gap-4"
          >
            <VBtn type="submit" @click="onFormSubmit()">
              Сохранить
            </VBtn>
            <VBtn
              color="secondary"
              variant="tonal"
              @click="onFormReset"
            >
              Назад
            </VBtn>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>
