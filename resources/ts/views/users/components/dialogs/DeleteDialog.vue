<script setup lang="ts">

interface Props {
  isDialogVisible: boolean
}
defineOptions({
  name: 'DeleteDialog',
})

interface Emit {
  (e: 'confirm'): void
  (e: 'update:isDialogVisible', val: boolean): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const onConfirm = () => {
  emit('confirm')
  emit('update:isDialogVisible', false)
}
const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDialogVisible', val)
}
</script>

<template>
  <VDialog
    max-width="500px"
    :model-value="props.isDialogVisible"
    @update:model-value="dialogModelValueUpdate"
  >
    <VCard>
      <VCardTitle>
        Вы уверены, что хотите удалить этот элемент?
      </VCardTitle>

      <VCardActions>
        <VSpacer />

        <VBtn
          color="error"
          variant="outlined"
          @click="dialogModelValueUpdate(false)"
        >
          Отмена
        </VBtn>

        <VBtn
          color="success"
          variant="elevated"
          @click="onConfirm"
        >
          Да
        </VBtn>

        <VSpacer />
      </VCardActions>
    </VCard>
  </VDialog>
</template>

<route lang="yaml">
meta:
  action: delete
  subject: User
</route>
