<script setup lang="ts">
defineOptions({
  name: 'UserTabSecurity',
})
const isNewPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- 👉 Change password -->
      <VCard title="Изменить пароль">
        <VCardText>
          <VAlert
            variant="tonal"
            color="warning"
            class="mb-4"
          >
            <VAlertTitle class="mb-2">
              Убедитесь, что пароль соответствует следующим требованиям
            </VAlertTitle>
            <span>Какие-то требования</span>
          </VAlert>

          <VForm @submit.prevent="() => { }">
            <VRow>
              <VCol
                cols="12"
                md="6"
              >
                <AppTextField
                  label="Новый пароль"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isNewPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isNewPasswordVisible = !isNewPasswordVisible"
                />
              </VCol>
              <VCol
                cols="12"
                md="6"
              >
                <AppTextField
                  label="Подтверждение пароля"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
                />
              </VCol>

              <VCol cols="12">
                <VBtn type="submit">
                  Сохранить
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
