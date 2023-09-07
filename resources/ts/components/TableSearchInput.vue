<script setup lang="ts">
defineProps({
  modelValue: String,
})

const emit = defineEmits(['update:modelValue'])

defineOptions({
  name: 'TableSearchInput',
  inheritAttrs: false,
})

const onInput = useDebounceFn((event: Event) => {
  const element = event.target as HTMLInputElement
  emit('update:modelValue', element.value)
}, 500)
</script>

<template>
  <AppTextField
    v-bind="{
      ...$attrs,
    }"
    class="table-search-input"
    @input="onInput"
  />
</template>

<style lang="scss">
.table-search-input {
  inline-size: 18rem;
}
</style>
