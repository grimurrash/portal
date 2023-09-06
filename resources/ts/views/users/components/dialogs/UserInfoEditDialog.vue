<script setup lang="ts">
import { Permission, Role } from '@/db/enums'
import { emailValidator, requiredValidator } from '@validators'

defineOptions({
  name: 'UserInfoEditDialog',
})
interface UserData {
  id: number | null
  fullName: string
  role: Array<Role>
  permission: Array<Permission>
  email: string
  avatar: string
}

interface Props {
  userData?: UserData
  isDialogVisible: boolean
}

interface Emit {
  (e: 'submit', value: UserData): void
  (e: 'update:isDialogVisible', val: boolean): void
}

const props = withDefaults(defineProps<Props>(), {
  userData: () => ({
    id: 0,
    fullName: '',
    role: [],
    permission: [],
    email: '',
    avatar: '',
  }),
})

const emit = defineEmits<Emit>()

const userData = ref<UserData>(structuredClone(toRaw(props.userData)))

watch(props, () => {
  userData.value = structuredClone(toRaw(props.userData))
})

const onFormSubmit = () => {
  emit('update:isDialogVisible', false)
  emit('submit', userData.value)
}

const onFormReset = () => {
  userData.value = structuredClone(toRaw(props.userData))

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
          Редактирование
        </VCardTitle>
      </VCardItem>

      <VCardText>
        <!-- 👉 Form -->
        <VForm
          class="mt-6"
          @submit.prevent="onFormSubmit"
        >
          <VRow>
            <!-- 👉 Full Name -->
            <VCol
              cols="12"
              md="6"
            >
              <AppTextField
                v-model="userData.fullName"
                label="ФИО"
                :rules="[requiredValidator]"
              />
            </VCol>

            <!-- 👉 Email -->
            <VCol
              cols="12"
              md="6"
            >
              <AppTextField
                v-model="userData.email"
                label="Электронная почта"
                :rules="[requiredValidator, emailValidator]"
              />
            </VCol>

            <!-- 👉 Role -->
            <VCol cols="12">
              <AppSelect
                v-model="userData.role"
                label="Роль"
                :rules="[requiredValidator]"
                :items="Object.values(Role)"
                multiple
                chips
              />
            </VCol>

            <!-- 👉 Permission -->
            <VCol cols="12">
              <AppSelect
                v-model="userData.permission"
                label="Права доступа"
                :rules="[requiredValidator]"
                :items="Object.values(Permission)"
                multiple
                chips
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
