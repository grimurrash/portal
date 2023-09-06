<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components/VForm'

import { emailValidator, requiredValidator } from '@validators'
import { PermissionEnum } from '@/types/enums/permission.enum'
import { RoleEnum } from '@/types/enums/role.enum'
import { useMutation } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { CreateUserDto } from '@/types/dto/management/users/create.dto'

interface Emit {
  (e: 'update:isDrawerOpen', value: boolean): void
}

defineOptions({
  name: 'AddNewUserDrawer',
})

interface Props {
  isDrawerOpen: boolean
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const isFormValid = ref(false)
const refForm = ref<VForm>()
const isPasswordVisible = ref(false)
const createUser = ref<CreateUserDto>({
  name: '',
  email: '',
  password: '',
  role: undefined,
  isEmailVerified: false,
})

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isDrawerOpen', false)
  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}
const { mutate } = useMutation({
  mutationFn: (userData: CreateUserDto) => UserService.create(userData),
})

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      mutate(createUser.value)
      emit('update:isDrawerOpen', false)
      nextTick(() => {
        refForm.value?.reset()
        refForm.value?.resetValidation()
      })
    }
  })
}

const handleDrawerModelValueUpdate = (val: boolean) => {
  emit('update:isDrawerOpen', val)
}
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
          <!-- 👉 Form -->
          <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
          >
            <VRow>
              <!-- 👉 Full name -->
              <VCol cols="12">
                <AppTextField
                  v-model="createUser.name"
                  :rules="[requiredValidator]"
                  label="ФИО"
                />
              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12">
                <AppTextField
                  v-model="createUser.email"
                  :rules="[requiredValidator, emailValidator]"
                  label="Электронная почта"
                />
              </VCol>

              <!-- 👉 Password -->
              <VCol cols="12">
                <AppTextField
                  v-model="createUser.password"
                  label="Пароль"
                  :rules="[requiredValidator]"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />
              </VCol>

              <!-- 👉 Role -->
              <VCol cols="12">
                <AppSelect
                  v-model="createUser.role"
                  label="Роль"
                  :rules="[requiredValidator]"
                  :items="Object.values(RoleEnum)"
                  chips
                />
              </VCol>

              <!-- 👉 Permission -->
              <VCol cols="12">
                <AppSelect
                  label="Права доступа"
                  :rules="[requiredValidator]"
                  :items="Object.values(PermissionEnum)"
                  chips
                />
              </VCol>

              <!-- 👉 Add and Cancel -->
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

<route lang="yaml">
meta:
  action: create
  subject: User
</route>
