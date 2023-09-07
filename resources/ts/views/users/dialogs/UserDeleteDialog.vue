<script setup lang="ts">
import { useMutation, useQueryClient } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { AxiosResponse } from 'axios'
import { useNotificationStore } from '@/store/useNotificationStore'

defineOptions({
  name: 'UserDeleteDialog',
})

interface Props {
  userId?: number
  isDialogVisible: boolean
}

interface Emit {
  (e: 'confirm'): void
  (e: 'update:isDialogVisible', val: boolean): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const queryClient = useQueryClient()
const notificationStore = useNotificationStore()

const { mutate: deleteMutation } = useMutation({
  mutationFn: (userId: number) => UserService.delete(userId),
  onSuccess: () => {
    dialogModelValueUpdate(false)
    queryClient.invalidateQueries({ queryKey: ['users'] })
  },
  onError: (error: AxiosResponse) => {
    notificationStore.sendErrorNotification((error.data as BaseAxiosErrorResponse).message)
  },
})

const onConfirm = () => {
  if (props.userId) {
    deleteMutation(props.userId)
  }
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
    <VCard title="Вы уверены, что хотите удалить пользователя?">
      <VCardText>
        После удаления пользователя можно будет востановить через администрацию
      </VCardText>

      <VCardActions>
        <VSpacer />

        <VBtn
          color="error"
          variant="elevated"
          @click="onConfirm"
        >
          Удалить
        </VBtn>

        <VBtn
          variant="tonal"
          color="secondary"
          @click="dialogModelValueUpdate(false)"
        >
          Отмена
        </VBtn>
        <VSpacer />
      </VCardActions>
    </VCard>
  </VDialog>
</template>
