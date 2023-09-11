<script lang="ts" setup>
import VueMultiSelect from 'vue-multiselect/src/Multiselect.vue'
import { Ref, useAttrs } from 'vue'

defineOptions({
  name: 'SearchSelect',
  inheritAttrs: false,
})

interface Props {
  modelValue: number | null
  options: Array<{id: number, label: string}>
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
})
const elementId = computed(() => {
  const attrs = useAttrs()
  const _elementIdToken = attrs.id || attrs.label

  return _elementIdToken ? `search-select-${_elementIdToken}-${Math.random().toString(36).slice(2, 7)}` : undefined
})
const emit = defineEmits(['update:modelValue'])

const selectValue: Ref<{id: number, label: string}|undefined>= ref(props.options.find(o => o.id === props.modelValue))

const label = computed(() => useAttrs().title as string | undefined)

watch(props, () => {
  if (props.modelValue !== selectValue.value?.id) {
    selectValue.value = props.options.find(o => o.id === props.modelValue)
  }
})

watch(selectValue, () => {
  emit('update:modelValue', selectValue.value?.id)
})

</script>

<template>
  <div
    class="app-select flex-grow-1"
    :class="$attrs.class"
  >
    <VLabel
      v-if="label"
      :for="elementId"
      class="mb-1 text-body-2 text-high-emphasis"
      :text="label"
    />
    <VueMultiSelect
      v-model:model-value="selectValue"
      :options="options"
      :id="elementId"
      :open-direction="$attrs['open-direction']"
      :options-limit="$attrs['options-limit']"
      label="label"
      track-by="id"
    />
  </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
