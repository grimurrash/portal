<script setup lang="ts">
import { useMutation, useQueryClient } from '@tanstack/vue-query'
import { useNotificationStore } from '@/store/useNotificationStore'
import { AxiosResponse } from 'axios'
import { EmployeeService } from '@/services/management/employee.service'
import { VFileInput, VForm } from 'vuetify/components'
import { requiredValidator } from '@validators'

interface Props {
  isDialogVisible: boolean
}

defineOptions({
  name: 'EmployeeImportDialog',
})

interface Emit {
  (e: 'update:isDialogVisible', val: boolean): void
}
const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const errors = ref<Record<string, string>>({})

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const importData = ref<ImportEmployeeRequestDto>({
  file: null,
  sheetName: null,
})

const { mutate: importEmployee } = useMutation({
  mutationFn: (data: ImportEmployeeRequestDto) => EmployeeService.importEmployees(data),
  onSuccess: () => {
    dialogModelValueUpdate(false)
    queryClient.invalidateQueries({ queryKey: ['employees'] })
  },
  onError: (error: AxiosResponse) => {
    if (error.status === 422) {
      errors.value = (error.data as UnprocessableErrorResponse).errors
    }
    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})

const onFormReset = () => {
  emit('update:isDialogVisible', false)
}

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}

const refForm = ref<VForm>()
const onFormImport = async (event: Event) => {
  errors.value = {}
  refForm.value?.validate().then(({ valid }) => {
    if (importData.value.file) {
      importEmployee(importData.value)
    }
  })
}


const handlerInputFile = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (target && target.files) {
    importData.value.file = target.files[0]
  }
}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 677"
    :model-value="props.isDialogVisible"
    @update:model-value="dialogModelValueUpdate"
  >
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="dialogModelValueUpdate(false)"/>

    <VCard class="pa-sm-8 pa-5" title="Импорт сотрудников">
      <VCardText>
        <VForm
          class="mt-6"
          ref="refForm"
          @submit.prevent="onFormImport"
        >
          <VRow>
            <VCol cols="12">
              <AppTextField
                v-model="importData.sheetName"
                label="Названия листа"
                name="sheet_name"
                placeholder='Названия листа (по умолчанию Модуль "КО")'
                :error-messages="errors.sheet_name"
              />
            </VCol>
            <VCol cols="12">
              <VFileInput
                chips
                show-size
                name="file"
                accept=".xls,.xlsx"
                placeholder="Выберите файл или перетащите его сюда..."
                drop-placeholder="Перетащите файл сюда..."
                label="Выберите файл или перетащите его сюда"
                :error-messages="errors.file"
                :rules="[requiredValidator]"
                @input="handlerInputFile"
              />
            </VCol>
            <VCol
              cols="12"
              class="d-flex flex-wrap justify-center gap-4"
            >
              <VBtn type="submit">
                Импортировать
              </VBtn>

              <VBtn
                color="secondary"
                variant="tonal"
                @click="onFormReset"
              >
                Отмена
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
