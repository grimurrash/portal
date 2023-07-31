<script setup lang="ts">
import { requiredValidator } from '@validators'
import type { UserProperties } from '@/db/types'
import { useUserListStore } from '@/views/users/useUserListStore'
import type { Options } from '@core/types'

interface DepartmentData {
  id: number
  title: string
  parentalDepartment: string
  head: string
  numberOfStaff: number
}

interface Props {
  departmentData: DepartmentData
  departments: string[]
  isDialogVisible: boolean
}

interface Emit {
  (e: 'submit', value: DepartmentData): void
  (e: 'update:isDialogVisible', val: boolean): void
}

const props = withDefaults(defineProps<Props>(), {
  departmentData: () => ({
    id: 0,
    title: '',
    parentalDepartment: '',
    head: '',
    numberOfStaff: 0,
  }),
})

const emit = defineEmits<Emit>()
const userListStore = useUserListStore()
const departmentData = ref<DepartmentData>(structuredClone(toRaw(props.departmentData)))

watch(props, () => {
  departmentData.value = structuredClone(toRaw(props.departmentData))
})

const users = ref<UserProperties[]>([])

const fetchUsers = () => {
  const options = ref<Options>({
    page: 1,
    itemsPerPage: 10,
    sortBy: [],
    groupBy: [],
    search: undefined,
  })

  userListStore.fetchUsers({
    q: '',
    role: [],
    options: options.value,
  }).then(response => {
    users.value = response.data.users
  }).catch(error => {
    console.error(error)
  })
}

watchEffect(fetchUsers)

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', departmentData.value)
}

const onFormReset = () => {
  departmentData.value = structuredClone(toRaw(props.departmentData))
  emit('update:isDialogVisible', false)
}

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
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
        <!-- 👉 Form -->
        <VForm
          class="mt-6"
          @submit.prevent="onFormSubmit"
        >
          <VRow>
            <!-- 👉 Department title -->
            <VCol cols="12">
              <AppTextField
                v-model="departmentData.title"
                label="Наименование отдела"
                :rules="[requiredValidator]"
                disabled
              />
            </VCol>

            <!-- 👉 Parental Department -->
            <VCol cols="12">
              <AppSelect
                v-model="departmentData.parentalDepartment"
                label="Родительский отдел"
                :rules="[requiredValidator]"
                :items="props.departments"
              />
            </VCol>

            <!-- 👉 Head of department -->
            <VCol cols="12">
              <AppSelect
                v-model="departmentData.head"
                label="Руководитель отдела"
                :rules="[requiredValidator]"
                :items="users.map(u => u.fullName)"
              />
            </VCol>

            <!-- 👉 Submit and Cancel -->
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
