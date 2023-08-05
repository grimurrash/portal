<script setup lang="ts">
defineProps({
  modelValue: String,
})

const emit = defineEmits(['update:modelValue'])

defineOptions({
  name: 'TableSearchInput',
  inheritAttrs: false,
})

const onInput = useDebounceFn(value => {
  emit('update:modelValue', value)
}, 500)
</script>

<template>
  <AppTextField
    v-bind="{
      ...$attrs,
    }"
    @input="onInput($event.target.value)"
  />
</template>
