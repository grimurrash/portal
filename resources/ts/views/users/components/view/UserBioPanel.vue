<script setup lang="ts">
import { avatarText } from '@core/utils/formatters'
import type { Permission, Role } from '@/db/enums'
import { useUserListStore } from '@/views/users/useUserListStore'
import UserInfoEditingDialog from '@/views/users/components/dialogs/UserInfoEditDialog.vue'

defineOptions({
  name: 'UserBioPanel',
})
interface Props {
  userData: {
    id: number
    fullName: string
    email: string
    role: Array<Role>
    permission: Array<Permission>
    avatar: string
  }
}

const props = defineProps<Props>()
const userListStore = useUserListStore()
const isUserInfoEditDialogVisible = ref(false)

const deleteUser = (id: number) => {
  userListStore.deleteUser(id)
}
</script>

<template>
  <VRow>
    <!-- SECTION User Details -->
    <VCol cols="12">
      <VCard v-if="props.userData">
        <VCardText class="text-center pt-15">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded
            :size="100"
            :color="!props.userData.avatar ? 'primary' : undefined"
            :variant="!props.userData.avatar ? 'tonal' : undefined"
          >
            <VImg
              v-if="props.userData.avatar"
              :src="props.userData.avatar"
            />
            <span
              v-else
              class="text-5xl font-weight-medium"
            >
              {{ avatarText(props.userData.fullName) }}
            </span>
          </VAvatar>

          <!-- 👉 User fullName -->
          <h6 class="text-h4 mt-4">
            {{ props.userData.fullName }}
          </h6>

          <!-- 👉 Role chip -->
          <div class="d-flex justify-center gap-1">
            <VChip
              v-for="role in props.userData.role"
              :key="role"
              color="primary"
              size="small"
              label
              class="text-capitalize mt-3"
            >
              <span>{{ role }}</span>
            </VChip>
          </div>
        </VCardText>

        <VDivider />

        <!-- 👉 Details -->
        <VCardText>
          <p class="text-sm text-uppercase text-disabled">
            Подробности
          </p>

          <!-- 👉 User Details list -->
          <VList class="card-list mt-2">
            <VListItem>
              <VListItemTitle>
                <h6 class="text-h6">
                  ФИО:
                  <span class="text-body-1">
                    {{ props.userData.fullName }}
                  </span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-h6">
                  Электронная почта:
                  <span class="text-body-1">{{ props.userData.email }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <div class="d-flex align-center gap-1">
                  <h6 class="text-h6">
                    Права доступа:
                  </h6>
                  <VChip
                    v-for="permission in props.userData.permission"
                    :key="permission"
                    color="primary"
                    size="small"
                    label
                    class="text-capitalize"
                  >
                    <span>{{ permission }}</span>
                  </VChip>
                </div>
              </VListItemTitle>
            </VListItem>
          </VList>
        </VCardText>

        <!-- 👉 Edit and Suspend button -->
        <VCardText class="d-flex justify-center">
          <VBtn
            variant="elevated"
            class="me-4"
            @click="isUserInfoEditDialogVisible = true"
          >
            Редактировать
          </VBtn>

          <VBtn
            variant="tonal"
            color="error"
            :to="{ name: 'users-list' }"
            @click="deleteUser(props.userData.id)"
          >
            Удалить
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <!-- !SECTION -->
  </VRow>

  <!--  👉 Edit user info dialog -->
  <UserInfoEditingDialog
    v-model:isDialogVisible="isUserInfoEditDialogVisible"
    :user-data="props.userData"
  />
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.75rem;
}

.text-capitalize {
  text-transform: capitalize !important;
}
</style>
