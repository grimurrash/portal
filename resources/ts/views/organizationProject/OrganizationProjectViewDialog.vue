<script setup lang="ts">
import type { Ref } from 'vue'
import { useQuery } from '@tanstack/vue-query'
import { OrganizationProjectService } from '@/services/activity/organization-project.service'

defineOptions({
  name: 'OrganizationProjectViewDialog',
})

interface Props {
  projectId: number
  isDialogVisible: boolean
}

interface Emit {
  (e: 'update:isDialogVisible', val: boolean): void
}

const emptyProject: OrganizationProjectInfoModelDto = {
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
  responsible_user_name: '',
  curator_user_id: 0,
  curator_user_name: '',
  organizer_user_name:'',
  organizer_user_id: 0,
  moderator_user_id: 0,
  moderator_user_name: '',
  change_logs: []
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()


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
const projectData: Ref<OrganizationProjectInfoModelDto> = computed(() => projectInfoResult.value?.data ?? emptyProject)

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}

const onFormReset = () => {
  dialogModelValueUpdate(false)
}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 677"
    :model-value="props.isDialogVisible"
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
    <VCard v-show="isSuccess" title="Информация о проекте">
      <VCardText>
        <VRow>
          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.number"
              persistent-placeholder
              type="number"
              label="№ согласно календарному плану"
              readonly
            />
          </VCol>
          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.name"
              label="Наименование проекта"
              readonly
            />
          </VCol>
          <VCol cols="12">
            <AppTextarea
              :value="projectData.description"
              label="Описание проекта"
              placeholder="Описание проекта"
              rows="2"
              readonly
              auto-grow
            />
          </VCol>
          <VCol cols="12">
            <AppTextarea
              :value="projectData.metrics"
              label="Ключевые показатели"
              placeholder="Ключевые показатели"
              rows="2"
              readonly
              auto-grow
            />
          </VCol>

          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.planned_coverage"
              persistent-placeholder
              type="number"
              label="Планируемый охват участников"
              readonly
            />
          </VCol>
          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.actual_coverage"
              persistent-placeholder
              type="number"
              label="Фактический охват участников"
              readonly
            />
          </VCol>
          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.curator_user_name"
              label="Куратор"
              readonly
            />
          </VCol>
          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.responsible_user_name"
              readonly
              label="Ответственный"
            />
          </VCol>
          <VCol cols="12" md="6">
            <AppTextField
              :value="projectData.organizer_user_name"
              readonly
              label="Организатор"
            />
          </VCol>

          <VCol v-if="projectData.moderator_user_name" cols="12" md="6">
            <AppTextField
              :value="projectData.moderator_user_name"
              readonly
              label="Модератор"
            />
          </VCol>
          <VCol v-else cols="12" md="6"/>

          <VCol  cols="12" md="6">
            <AppTextField
              :value="projectData.start_date"
              label="Дата начала"
              readonly
              placeholder="Дата начала"
            />
          </VCol>
          <VCol  cols="12" md="6">
            <AppTextField
              :value="projectData.end_date"
              label="Дата окончания"
              readonly
              placeholder="Дата окончания"
            />
          </VCol>
          <VCol cols="12">
            <OrganizationProjectDateList v-model:items="projectData.dates" :is-read-only="true"/>
          </VCol>
        </VRow>
      </VCardText>
      <VCardText>
        <VRow>
          <VCol
            cols="12"
            class="d-flex flex-wrap justify-center gap-4"
          >
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
