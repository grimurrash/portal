declare interface PaginateListResponse<T> {
  items: Array<T>
  total_count: number
}

declare interface OptionItemModel {
  id: number
  label: string
}
