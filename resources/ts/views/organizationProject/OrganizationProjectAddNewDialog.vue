<script setup lang="ts">
import type { Ref } from 'vue'
import { useMutation, useQueryClient } from '@tanstack/vue-query'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'

interface Props {
  isDialogVisible: boolean
}
interface Emit {
  (e: 'update:isDialogVisible', val: boolean): void
}
defineOptions({
  name: 'OrganizationProjectAddNewDialog',
})
const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const emptyProject: CreateOrganizationProjectRequestDto = {
  number: null,
  name: '',
  description: '',
  start_date: null,
  end_date: null,
  dates: [],
  metrics: '',
  planned_coverage: null,
  actual_coverage: null,
  responsible_user_id: null,
  curator_user_id: null
}

const projectData: Ref<CreateOrganizationProjectRequestDto> = ref<CreateOrganizationProjectRequestDto>(structuredClone(toRaw(emptyProject)))

const errors = ref<Record<string, string>>({})

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const { mutate: createProject } = useMutation({
  mutationFn: (projectData: CreateOrganizationProjectRequestDto) => OrganizationProjectService.create(projectData),
  onSuccess: () => {
    dialogModelValueUpdate(false)
    projectData.value = structuredClone(toRaw(emptyProject))
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
    .then(() => createProject(projectData.value))
}

const onFormReset = () => {
  dialogModelValueUpdate(false)
  projectData.value = structuredClone(toRaw(emptyProject))
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
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="dialogModelValueUpdate(false)" />

    <VCard title="Добавление проекта">
      <VCardText>
        <OrganizationProjectForm v-model:project-data="projectData" :errors="errors" @submit-form="onFormSubmit()" ref="refForm"/>
      </VCardText>
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            class="d-flex flex-wrap justify-center gap-4"
          >
            <VBtn type="submit" @click.prevent="onFormSubmit">
              Добавить проект
            </VBtn>

            <VBtn
              color="secondary"
              variant="tonal"
              @click="onFormReset()"
            >
              Назад
            </VBtn>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
  </VDialog>
</template>
