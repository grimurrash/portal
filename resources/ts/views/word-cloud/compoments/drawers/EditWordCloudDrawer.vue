<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import { VForm } from 'vuetify/components/VForm'

import { betweenValidator, integerValidator, requiredValidator } from '@validators'
import type { WordCloudProperties } from '@/db/types'

defineOptions({
  name: 'EditWordCloudDrawer',
})

interface Props {
  wordCloudData?: WordCloudProperties
  isDrawerOpen: boolean
}
interface Emit {
  (e: 'update:isDrawerOpen', value: boolean): void
  (e: 'submit', value: WordCloudProperties): void
}

const props = withDefaults(defineProps<Props>(), {
  wordCloudData: () => ({
    id: 0,
    event: '',
    question: '',
    creator: '',
    cloudLink: '',
    questionLink: '',
    numberOfResponses: 0,
    textColor: '',
    uniqueCheckbox: false,
    wordCloudTitle: '',
    backgroundImage: '',
    logo: '',
    exceptions: '',
    extraCSS: '',
    minTextSize: 30,
    maxTextSize: 120,
    numberOfResponsesCheckbox: false,
    numberOfResponsesSize: 20,
    textRotationAngle: 0,
  }),
})

const emit = defineEmits<Emit>()

const wordCloudData = ref<WordCloudProperties>(structuredClone(toRaw(props.wordCloudData)))

watch(props, () => {
  wordCloudData.value = structuredClone(toRaw(props.wordCloudData))
})

const isFormValid = ref(false)
const refForm = ref<VForm>()

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
      emit('submit', wordCloudData.value)
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
      title="Редактирование облака слов"
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
                  v-model="wordCloudData.event"
                  :rules="[requiredValidator]"
                  label="Наименование"
                />
              </VCol>

              <!-- 👉 Question -->
              <VCol cols="12">
                <AppTextarea
                  v-model="wordCloudData.question"
                  :rules="[requiredValidator]"
                  label="Вопрос"
                />
              </VCol>

              <!-- 👉 Text color -->
              <VCol cols="12">
                <AppSelect
                  v-model="wordCloudData.textColor"
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
                  v-model="wordCloudData.uniqueCheckbox"
                  true-icon="tabler-check"
                  false-icon="tabler-x"
                />
              </VCol>

              <!-- 👉 Word cloud title -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.wordCloudTitle"
                  label="Заголовок страницы облака слова"
                />
              </VCol>

              <!-- 👉 Background image -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.backgroundImage"
                  label="Фоновое изображение"
                />
              </VCol>

              <!-- 👉 Logo -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.logo"
                  label="Логотип"
                />
              </VCol>

              <!-- 👉 Exceptions -->
              <VCol cols="12">
                <AppTextarea
                  v-model="wordCloudData.exceptions"
                  label="Слова исключения"
                />
              </VCol>

              <!-- 👉 Extra CSS -->
              <VCol cols="12">
                <AppTextarea
                  v-model="wordCloudData.extraCSS"
                  label="Дополнительный CSS"
                />
              </VCol>

              <!-- 👉 Minimum text size -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.minTextSize"
                  :rules="[integerValidator]"
                  label="Минимальный размер текста"
                />
              </VCol>

              <!-- 👉 Maximum text size -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.maxTextSize"
                  :rules="[integerValidator]"
                  label="Максимальный размер текста"
                />
              </VCol>

              <!-- 👉 Number of responses checkbox -->
              <VCol cols="12">
                <span>Показывать кол-во ответов</span>
                <VCheckbox
                  v-model="wordCloudData.numberOfResponsesCheckbox"
                  true-icon="tabler-check"
                  false-icon="tabler-x"
                />
              </VCol>

              <!-- 👉 Maximum text size -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.numberOfResponsesSize"
                  :rules="[integerValidator]"
                  label="Размер кол-ва ответов"
                />
              </VCol>

              <!-- 👉 Text rotation angle -->
              <VCol cols="12">
                <AppTextField
                  v-model="wordCloudData.textRotationAngle"
                  :rules="[betweenValidator(wordCloudData.textRotationAngle, 0, 360)]"
                  label="Угол поворота текста"
                />
              </VCol>

              <!-- 👉 Add and Cancel -->
              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                >
                  Сохранить изменения
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
