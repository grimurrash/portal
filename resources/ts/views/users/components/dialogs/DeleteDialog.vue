<script setup lang="ts">
import { useMutation } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'

interface Props {
  isDialogVisible: boolean
  userData: any
}
interface Emit {
  (e: 'confirm'): void
  (e: 'update:isDialogVisible', val: boolean): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()

const { mutate } = useMutation({
  mutationFn: (id: number) => UserService.delete(id),
})

const onConfirm = () => {
  mutate(props.userData.id)
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
  action: read
  subject: User
</route>
