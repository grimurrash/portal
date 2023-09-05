<script setup lang="ts">
import { useQuery } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import { ShowUserResponse } from '@/types/model/management/user.model'
import { toRoleEnumRu } from '@/types/enums/utils'
import { avatarText } from '@core/utils/formatters'
import UserInfoEditingDialog from '@/views/users/components/dialogs/UserInfoEditDialog.vue'
import DeleteDialog from '@/views/users/components/dialogs/DeleteDialog.vue'

defineOptions({
  name: 'UserBioPanel',
})
interface Props {
  userId: number
}

const props = defineProps<Props>()
const isUserInfoEditDialogVisible = ref(false)
const isUserDeleteDialogVisible = ref(false)

const { data: showQueryResult } = useQuery({
  queryKey: ['show-user'],
  queryFn: () => UserService.show(props.userId)
})

const user = computed((): ShowUserResponse => showQueryResult.value?.data ?? undefined)

const update = () => {
  
}
</script>

<template>
  <VRow>
    <!-- SECTION User Details -->
    <VCol cols="12">
      <VCard v-if="user">
        <VCardText class="text-center pt-15">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded
            :size="100"
            :color="!user.avatar ? 'primary' : undefined"
            :variant="!user.avatar ? 'tonal' : undefined"
          >
            <VImg
              v-if="user.avatar"
              :src="user.avatar"
            />
            <span
              v-else
              class="text-5xl font-weight-medium"
            >
              {{ avatarText(user.name) }}
            </span>
          </VAvatar>

          <!-- 👉 User fullName -->
          <h6 class="text-h4 mt-4">
            {{ user.name }}
          </h6>

          <!-- 👉 Role chip -->
          <div class="d-flex justify-center gap-1">
            <VChip
              v-for="role in [user.role]"
              :key="role"
              color="primary"
              size="small"
              label
              class="text-capitalize mt-3"
            >
              <span>{{ toRoleEnumRu(role) }}</span>
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
                    {{ user.name }}
                  </span>
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
                <div class="d-flex align-center gap-1">
                  <h6 class="text-h6">
                    Права доступа:
                  </h6>
                  <VChip
                    v-if="user.permission"
                    v-for="permission in [user.permissions]"
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

        <!-- 👉 Edit and Delete button -->
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
            @click="isUserDeleteDialogVisible = true"
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
    :user-data="user"
    @submit="update"
  />

  <!--  👉 Delete user dialog -->
  <DeleteDialog
    v-model:isDialogVisible="isUserDeleteDialogVisible"
    :user-data="user"
    @confirm="update"
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
