<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import { VForm } from 'vuetify/components/VForm'
import { emailValidator, requiredValidator } from '@validators'
import { PermissionNames } from '@/types/enums/permission.enum'
import { RoleNames } from '@/types/enums/role.enum'
import { useMutation, useQueryClient } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { objectToOptions } from '@/utils/enums'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'

defineOptions({
  name: 'AddUserDrawer',
})
interface Props {
  isDrawerOpen: boolean
}
interface Emit {
  (e: 'update:isDrawerOpen', value: boolean): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const refForm = ref<VForm>()
const isPasswordVisible = ref(false)

const userData = ref<CreateUserRequestDto>({
  name: '',
  email: '',
  password: '',
  roles: [],
  permissions: [],
  isEmailVerified: true,
})
const errors = ref<Record<string, string>>({})

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isDrawerOpen', false)
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const { mutate: createUser } = useMutation({
  mutationFn: (userData: CreateUserRequestDto) => UserService.create(userData),
  onSuccess: () => {
    closeNavigationDrawer()
    queryClient.invalidateQueries({ queryKey: ['users'] })
  },
  onError: (error: AxiosResponse) => {
    if (error.status === 422) {
      errors.value = (error.data as UnprocessableErrorResponse).errors
    }
    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      createUser(userData.value)
    }
  })
}

const handleDrawerModelValueUpdate = (val: boolean) => {
  emit('update:isDrawerOpen', val)
}
const roleOptions = objectToOptions(RoleNames)
const permissionOptions = objectToOptions(PermissionNames)
</script>

<template>
  <VNavigationDrawer
    temporary
    :width="400"
    location="end"
    class="scrollable-content"
    :model-value="props.isDrawerOpen"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Title -->
    <AppDrawerHeaderSection
      title="Добавить пользователя"
      @cancel="closeNavigationDrawer"
    />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <VForm
            ref="refForm"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <VCol cols="12">
                <AppTextField
                  v-model="userData.name"
                  :error-messages="errors.name"
                  :rules="[requiredValidator]"
                  label="ФИО"
                />
              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12">
                <AppTextField
                  v-model="userData.email"
                  :error-messages="errors.name"
                  :rules="[requiredValidator, emailValidator]"
                  label="Электронная почта"
                />
              </VCol>

              <!-- 👉 Password -->
              <VCol cols="12">
                <AppTextField
                  v-model="userData.password"
                  :error-messages="errors.password"
                  label="Пароль"
                  :rules="[requiredValidator]"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>

              <VCol cols="12">
                <AppSelect
                  v-model="userData.roles"
                  :error-messages="errors.roles"
                  label="Роль"
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
                  :error-messages="errors.permissions"
                  label="Права доступа"
                  :items="permissionOptions"
                  item-value="id"
                  item-title="label"
                  chips
                  multiple
                />
              </VCol>

              <VCol cols="12">
                <VSwitch
                  v-model="userData.isEmailVerified"
                  :error-messages="errors.isEmailVerified"
                  :inset="false"
                  color="secondary"
                  disabled
                  label="Без подтверждения почты"
                />
              </VCol>

              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                >
                  Добавить
                </VBtn>

                <VBtn
                  type="reset"
                  variant="tonal"
                  color="secondary"
                  @click="closeNavigationDrawer"
                >
                  Отмена
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>
