<script setup lang="ts">
import type { Ref } from 'vue'
import { useMutation, useQueryClient } from '@tanstack/vue-query'
import { DepartmentService } from '@/services/management/department.service'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'

interface Props {
  departmentData: DepartmentListItemModel
  isDialogVisible: boolean
}
defineOptions({
  name: 'DepartmentEditDialog',
})
const props = withDefaults(defineProps<Props>(), {
  departmentData: () => ({
    id: 0,
    name: '',
    parent_department_id: 0,
    parent_department_name: '',
    head_employee_id: 0,
    head_employee_name: '',
    employees_count: 0,
  }),
})

const emit = defineEmits<Emit>()

const departmentData: Ref<DepartmentListItemModel> = ref<DepartmentListItemModel>({
  id: 0,
  name: '',
  parent_department_id: 0,
  parent_department_name: '',
  head_employee_id: 0,
  head_employee_name: '',
  employees_count: 0,
})

const errors = ref<Record<string, string | undefined>>({
  global: undefined,
})

const cloneDepartment = () => {
  const cloneDepartmentModel = structuredClone(toRaw(props.departmentData))

  departmentData.value.id = cloneDepartmentModel.id
  departmentData.value.name = cloneDepartmentModel.name
  departmentData.value.parent_department_id = cloneDepartmentModel.parent_department_id
  departmentData.value.head_employee_id = cloneDepartmentModel.head_employee_id
}

interface Emit {
  (e: 'update:isDialogVisible', val: boolean): void
}

const isEnabled = ref(false)

watch(props, () => {
  cloneDepartment()
  isEnabled.value = true
})

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const { mutate: editDepartment } = useMutation({
  mutationFn: (department: DepartmentListItemModel) => DepartmentService.update(department),
  onSuccess: () => {
    dialogModelValueUpdate(false)
    queryClient.invalidateQueries({ queryKey: ['departments', 'main-list'] })
    queryClient.invalidateQueries({ queryKey: ['departments', 'parent-options'] })
    queryClient.invalidateQueries({ queryKey: ['employees', 'options-by-department', { department_id: departmentData.value.id }] })
  },
  onError: (error: AxiosResponse) => {
    if (error.status === 422) {
      errors.value = (error.data as UnprocessableErrorResponse).errors
    }

    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})

const onFormSubmit = () => {
  editDepartment(departmentData.value)
}

const onFormReset = () => {
  cloneDepartment()
  dialogModelValueUpdate(false)
}
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 677"
    :model-value="props.isDialogVisible"
    @update:model-value="dialogModelValueUpdate"
  >
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="dialogModelValueUpdate(false)" />

    <VCard class="pa-sm-8 pa-5">
      <VCardItem class="text-center">
        <VCardTitle class="text-h5 mb-3">
          Измененить отдел
        </VCardTitle>
      </VCardItem>

      <VCardText>
        <VForm
          class="mt-6"

          @submit.prevent="onFormSubmit"
        >
          <VRow>
            <VCol cols="12">
              <AppTextField
                v-model="departmentData.name"
                label="Наименование отдела"
                disabled
                :error-messages="errors.name"
              />
            </VCol>

            <VCol cols="12">
              <AllDepartmentSelect
                v-model="departmentData.parent_department_id"
                label="Родительский отдел"
                :is-enabled="isEnabled"
                :error-messages="errors.parent_department_id"
              />
            </VCol>

            <VCol cols="12">
              <EmployeeByDepartmentSelect
                v-model="departmentData.head_employee_id"
                :department-id="departmentData.id"
                label="Руководитель отдела"
                :is-enabled="isEnabled"
                :error-messages="errors.head_employee_id"
              />
            </VCol>

            <VCol
              cols="12"
              class="d-flex flex-wrap justify-center gap-4"
            >
              <VBtn type="submit">
                Сохранить изменения
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
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>
