<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components/VForm'
import { betweenValidator, integerValidator, requiredValidator } from '@validators'
import type { WordCloudProperties } from '@/db/types'

interface Props {
  isDrawerOpen: boolean
}
interface Emit {
  (e: 'update:isDrawerOpen', value: boolean): void
  (e: 'wordCloudData', value: WordCloudProperties): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const userData = JSON.parse(localStorage.getItem('userData') || 'null')
const isFormValid = ref(false)
const refForm = ref<VForm>()
const event = ref('')
const question = ref('')
const textColor = ref('color1')
const uniqueCheckbox = ref(false)
const wordCloudTitle = ref('Облако слов')
const backgroundImage = ref('https://portal.cpvs.moscow/public/images/backgroud.svg')
const logo = ref('')
const exceptions = ref('')
const extraCSS = ref('')
const minTextSize = ref(30)
const maxTextSize = ref(120)
const numberOfResponsesCheckbox = ref(false)
const numberOfResponsesSize = ref(20)
const textRotationAngle = ref(0)

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isDrawerOpen', false)

  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit('wordCloudData', {
        id: 1,
        event: event.value,
        question: question.value,
        creator: userData.id,
        cloudLink: '',
        questionLink: '',
        numberOfResponses: 0,
        textColor: textColor.value,
        uniqueCheckbox: uniqueCheckbox.value,
        wordCloudTitle: wordCloudTitle.value,
        backgroundImage: backgroundImage.value,
        logo: logo.value,
        exceptions: exceptions.value,
        extraCSS: extraCSS.value,
        minTextSize: minTextSize.value,
        maxTextSize: maxTextSize.value,
        numberOfResponsesCheckbox: numberOfResponsesCheckbox.value,
        numberOfResponsesSize: numberOfResponsesSize.value,
        textRotationAngle: textRotationAngle.value,
      })
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
      title="Добавление облака слов"
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
              <!-- 👉 Event title -->
              <VCol cols="12">
                <AppTextField
                  v-model="event"
                  :rules="[requiredValidator]"
                  label="Наименование"
                  placeholder="Наименование мероприятия"
                />
              </VCol>

              <!-- 👉 Question -->
              <VCol cols="12">
                <AppTextarea
                  v-model="question"
                  :rules="[requiredValidator]"
                  label="Вопрос"
                  placeholder="Вопрос"
                />
              </VCol>

              <!-- 👉 Text color -->
              <VCol cols="12">
                <AppSelect
                  v-model="textColor"
                  label="Цветовое оформление текста"
                  :rules="[requiredValidator]"
                  :items="['color1', 'color2']"
                  variant="solo"
                />
              </VCol>

              <!-- 👉 Unique checkbox -->
              <VCol cols="12">
                <span>Проверка на уникальность</span>
                <VCheckbox
                  v-model="uniqueCheckbox"
                  true-icon="tabler-check"
                  false-icon="tabler-x"
                />
              </VCol>

              <!-- 👉 Word cloud title -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudTitle"
                  label="Заголовок страницы облака слова"
                />
              </VCol>

              <!-- 👉 Background image -->
              <VCol cols="12">
                <AppTextField
                  v-model="backgroundImage"
                  label="Фоновое изображение"
                />
              </VCol>

              <!-- 👉 Logo -->
              <VCol cols="12">
                <AppTextField
                  v-model="logo"
                  label="Логотип"
                  placeholder="Ссылка на логотип"
                />
              </VCol>

              <!-- 👉 Exceptions -->
              <VCol cols="12">
                <AppTextarea
                  v-model="exceptions"
                  label="Слова исключения"
                  placeholder="Слова исключения, через запятую"
                />
              </VCol>

              <!-- 👉 Extra CSS -->
              <VCol cols="12">
                <AppTextarea
                  v-model="extraCSS"
                  label="Дополнительный CSS"
                  placeholder="Дополнительный CSS"
                />
              </VCol>

              <!-- 👉 Minimum text size -->
              <VCol cols="12">
                <AppTextField
                  v-model="minTextSize"
                  :rules="[integerValidator]"
                  label="Минимальный размер текста"
                />
              </VCol>

              <!-- 👉 Maximum text size -->
              <VCol cols="12">
                <AppTextField
                  v-model="maxTextSize"
                  :rules="[integerValidator]"
                  label="Максимальный размер текста"
                />
              </VCol>

              <!-- 👉 Number of responses checkbox -->
              <VCol cols="12">
                <span>Показывать кол-во ответов</span>
                <VCheckbox
                  v-model="numberOfResponsesCheckbox"
                  true-icon="tabler-check"
                  false-icon="tabler-x"
                />
              </VCol>

              <!-- 👉 Maximum text size -->
              <VCol cols="12">
                <AppTextField
                  v-model="numberOfResponsesSize"
                  :rules="[integerValidator]"
                  label="Размер кол-ва ответов"
                />
              </VCol>

              <!-- 👉 Text rotation angle -->
              <VCol cols="12">
                <AppTextField
                  v-model="textRotationAngle"
                  :rules="[betweenValidator(textRotationAngle, 0, 360)]"
                  label="Угол поворота текста"
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
