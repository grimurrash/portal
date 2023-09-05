<script setup lang="ts">
import { emailValidator, requiredValidator } from '@validators'
import { RoleEnum } from '@/types/enums/role.enum'
import { PermissionEnum } from '@/types/enums/permission.enum'
import { toRoleEnumRu } from '@/types/enums/utils'
import { useMutation } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { UserListItemModel } from '@/types/model/management/user.model'

interface UserData {
  id: number | null
  name: string
  role: RoleEnum | undefined
  permission: PermissionEnum | undefined
  email: string
  avatar: string
}

interface Props {
  userData?: UserData
  isDialogVisible: boolean
}

interface Emit {
  (e: 'submit'): void
  (e: 'update:isDialogVisible', val: boolean): void
}

const props = withDefaults(defineProps<Props>(), {
  userData: () => ({
    id: 0,
    name: '',
    email: '',
    role: undefined,
    permission: undefined,
    avatar: '',
  }),
})

const emit = defineEmits<Emit>()

const userData = ref<UserData>(structuredClone(toRaw(props.userData)))

watch(props, () => {
  userData.value = structuredClone(toRaw(props.userData))
  userData.value.role = toRoleEnumRu(userData.value.role)
})

const { mutate } = useMutation({
  mutationFn: (user: UserListItemModel) => UserService.update(user),
})

const onFormSubmit = () => {
  mutate(userData.value)
  emit('submit')
  emit('update:isDialogVisible', false)
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
                v-model="userData.name"
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
                :items="Object.values(RoleEnum)"
                chips
              />
            </VCol>

            <!-- 👉 Permission -->
            <VCol cols="12">
              <AppSelect
                v-model="userData.permission"
                label="Права доступа"
                :rules="[requiredValidator]"
                :items="Object.values(PermissionEnum)"
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
