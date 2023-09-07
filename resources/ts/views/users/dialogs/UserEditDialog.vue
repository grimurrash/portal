<script setup lang="ts">
import { emailValidator, requiredValidator } from '@validators'
import { RoleNames } from '@/types/enums/role.enum'
import { PermissionNames } from '@/types/enums/permission.enum'
import { useMutation, useQueryClient } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'
import { VForm } from 'vuetify/components/VForm'
import { objectToOptions } from '@/utils/enums'

defineOptions({
  name: 'UserEditDialog',
})

interface Props {
  userData?: UpdateUserRequestDto
  isDialogVisible: boolean
}

interface Emit {
  (e: 'update:isDialogVisible', val: boolean): void
}

const errors = ref<Record<string, string>>({})
const props = withDefaults(defineProps<Props>(), {
  userData: () => ({
    id: 0,
    name: '',
    email: '',
    roles: [],
    permissions: [],
  }),
})

const emit = defineEmits<Emit>()

const userData = ref<UpdateUserRequestDto>(props.userData)

watch(props, () => {
  userData.value = structuredClone(toRaw(props.userData))
})

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const { mutate: updateUser } = useMutation({
  mutationFn: (user: UpdateUserRequestDto) => UserService.update(user),
  onSuccess: () => {
    dialogModelValueUpdate(false)
    queryClient.invalidateQueries({ queryKey: ['users'] })
  },
  onError: (error: AxiosResponse) => {
    if (error.status === 422) {
      errors.value = (error.data as UnprocessableErrorResponse).errors
    }
    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})
const refForm = ref<VForm>()
const onFormSubmit = () => {
  errors.value = {}
  return refForm.value?.validate().then(({valid: isValid}) => {
    if (isValid) {
      updateUser(userData.value)
    }
  })
}

const onFormReset = () => {
  userData.value = structuredClone(toRaw(props.userData))
  emit('update:isDialogVisible', false)
}

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}

const roleOptions = objectToOptions(RoleNames)
const permissionOptions = objectToOptions(PermissionNames)
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
          ref="refForm"
          @submit.prevent="onFormSubmit"
        >
          <VRow>
            <VCol
              cols="12"
              md="6"
            >
              <AppTextField
                v-model="userData.name"
                label="ФИО"
                :error-messages="errors.name"
                :rules="[requiredValidator]"
              />
            </VCol>

            <VCol
              cols="12"
              md="6"
            >
              <AppTextField
                v-model="userData.email"
                label="Электронная почта"
                :error-messages="errors.email"
                :rules="[requiredValidator, emailValidator]"
              />
            </VCol>

            <VCol cols="12">
              <AppSelect
                v-model="userData.roles"
                label="Роль"
                :error-messages="errors.roles"
                :rules="[requiredValidator]"
                :items="roleOptions"
                item-value="id"
                item-title="label"
                chips
                multiple
              />
            </VCol>

            <VCol cols="12">
              <AppSelect
                v-model="userData.permissions"
                label="Права доступа"
                :error-messages="errors.permissions"
                :rules="[requiredValidator]"
                :items="permissionOptions"
                item-value="id"
                item-title="label"
                chips
                multiple
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
                variant="tonal"
                color="secondary"
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
