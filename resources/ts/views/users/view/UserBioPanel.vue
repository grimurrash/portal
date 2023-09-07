<script setup lang="ts">
import { PermissionNames } from '@/types/enums/permission.enum'
import { RoleNames } from '@/types/enums/role.enum'
import { avatarText } from '@core/utils/formatters'

defineOptions({
  name: 'UserBioPanel',
})
interface Props {
  user: UserInfoResponse
}

const props = defineProps<Props>()
const isUserInfoEditDialogVisible = ref(false)
const isUserDeleteDialogVisible = ref(false)

const roleLabel = (role:string) => RoleNames[role as keyof typeof RoleNames]
const permissionLabel = (permission: string) => PermissionNames[permission as keyof typeof PermissionNames]
</script>

<template>
  <VRow>
    <UserDeleteDialog v-model:is-dialog-visible="isUserDeleteDialogVisible" :user-id="props.user.id" />

    <UserEditDialog
      v-model:isDialogVisible="isUserInfoEditDialogVisible"
      :user-data="user"
    />

    <VCol cols="12">
      <VCard>
        <VCardText class="text-center pt-15">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded
            :size="100"
            color="primary"
            variant="tonal"
          >
            <span class="text-5xl font-weight-medium">
              {{ avatarText(user.name) }}
            </span>
          </VAvatar>

          <h6 class="text-h4 mt-4">
            {{ user.name }}
          </h6>

          <div class="d-flex justify-center gap-1 flex-wrap">
            <VChip
              v-for="role in user.roles"
              :key="role"
              color="primary"
              size="small"
              label
              class="text-capitalize mt-3"
            >
              <span>{{ roleLabel(role) }}</span>
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
                  <span class="text-body-1">{{ user.name }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-h6">
                  Электронная почта:
                  <span class="text-body-1">{{ user.email }}</span>
                </h6>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <h6 class="text-h6 mb-2">
                  Права доступа:
                </h6>
                <div class="d-flex align-center gap-1 flex-wrap" >
                  <VChip
                    v-if="user.permissions"
                    v-for="permission in user.permissions"
                    :key="permission"
                    color="primary"
                    size="small"
                    label
                    class="text-capitalize"
                  >
                    <span>{{ permissionLabel(permission) }}</span>
                  </VChip>
                </div>
              </VListItemTitle>
            </VListItem>
          </VList>
        </VCardText>

        <VCardText class="d-flex justify-center">
          <VBtn
            variant="elevated"
            class="me-4"
            v-if="$can('update', 'user')"
            @click="isUserInfoEditDialogVisible = true"
          >
            Редактировать
          </VBtn>
          <VBtn
            variant="tonal"
            color="error"
            v-if="$can('delete', 'user')"
            @click="isUserDeleteDialogVisible = true"
          >
            Удалить
          </VBtn>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.75rem;
}
</style>

<route lang="yaml">
meta:
  action: read
  subject: User
</route>
