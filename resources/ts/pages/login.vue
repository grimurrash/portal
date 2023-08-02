<script setup lang="ts">
import { VForm } from 'vuetify/components/VForm'
import { useMutation } from '@tanstack/vue-query'
import { useGenerateImageVariant } from '@core/composable/useGenerateImageVariant'
import authLoginDark from '@images/pages/login/login-dark.svg'
import authLoginLight from '@images/pages/login/login.svg'
import authV2MaskDark from '@images/pages/misc-mask-dark.png'
import authV2MaskLight from '@images/pages/misc-mask-light.png'
import { themeConfig } from '@themeConfig'
import { emailValidator, requiredValidator } from '@validators'
import { useAppAbility } from '@/plugins/casl/useAppAbility'
import { AuthService } from '@/services/auth/auth.service'

const authThemeImg = useGenerateImageVariant(authLoginLight, authLoginDark, authLoginLight, authLoginDark, true)

const authThemeMask = useGenerateImageVariant(authV2MaskLight, authV2MaskDark)

const isPasswordVisible = ref(false)

const route = useRoute()
const router = useRouter()

const ability = useAppAbility()

const errors = ref<Record<string, string | undefined>>({
  email: undefined,
  password: undefined,
})

const refVForm = ref<VForm>()

const authLogin = ref<AuthLoginDto>({
  email: '',
  password: '',
  remember_me: false,
})

const { mutate } = useMutation({
  mutationKey: 'login',
  mutationFn: (authData: AuthLoginDto) => AuthService.login(authData),
  onSuccess: ({ data }) => {
    const loginResponse: LoginResponse = data

    localStorage.setItem('userAbilities', JSON.stringify(loginResponse.abilities))
    ability.update(loginResponse.abilities)

    localStorage.setItem('userData', JSON.stringify(loginResponse.user))
    localStorage.setItem('accessToken', JSON.stringify(loginResponse.token))
    localStorage.setItem('accessTokenExpiredAt', JSON.stringify(loginResponse.token_expired_at))

    router.replace(route.query.to ? String(route.query.to) : '/')
  },
  onError: ({ error }) => {
    errors.value = error.errors
  },
})

const onSubmit = (event: Event) => {
  event.preventDefault()
  refVForm.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid)
        mutate(authLogin.value)
    })
}
</script>

<template>
  <VRow
    no-gutters
    class="auth-wrapper bg-surface"
  >
    <VCol
      lg="8"
      class="d-none d-lg-flex"
    >
      <div class="position-relative bg-background rounded-lg w-100 ma-8 me-0">
        <div class="d-flex align-center justify-center w-100 h-100">
          <VImg
            max-width="505"
            :src="authThemeImg"
            class="auth-illustration mt-16 mb-2"
          />
        </div>

        <VImg
          :src="authThemeMask"
          class="auth-footer-mask"
        />
      </div>
    </VCol>

    <VCol
      cols="12"
      lg="4"
      class="auth-card-v2 d-flex align-center justify-center"
    >
      <VCard
        flat
        :max-width="500"
        class="mt-12 mt-sm-0 pa-4"
      >
        <VCardText>
          <h5 class="text-h5 mb-1">
            Добро пожаловать в <span class="text-capitalize">{{ themeConfig.app.title }}</span>! 👋🏻
          </h5>
          <p class="mb-0">
            Пожалуйста, войдите в свою учетную запись
          </p>
        </VCardText>
        <VCardText>
          <VForm
            ref="refVForm"
            @submit.prevent
            @submit.stop.prevent="onSubmit"
          >
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <AppTextField
                  v-model="authLogin.email"
                  label="Электронная почта"
                  type="email"
                  autofocus
                  :rules="[requiredValidator, emailValidator]"
                  :error-messages="errors.email"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <AppTextField
                  v-model="authLogin.password"
                  label="Пароль"
                  :rules="[requiredValidator]"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :error-messages="errors.password"
                  :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <div class="d-flex align-center flex-wrap justify-space-between mt-2 mb-4">
                  <VCheckbox
                    v-model="authLogin.remember_me"
                    label="Запомнить меня"
                  />
                  <!--                  <RouterLink -->
                  <!--                    class="text-primary ms-2 mb-1" -->
                  <!--                    :to="{ name: 'forgot-password' }" -->
                  <!--                  > -->
                  <!--                    Забыли пароль? -->
                  <!--                  </RouterLink> -->
                </div>

                <VBtn
                  block
                  type="submit"
                >
                  Login
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
  action: read
  subject: Auth
  redirectIfLoggedIn: true
</route>
