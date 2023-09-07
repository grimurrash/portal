declare type SortItem = {
  key: string,
  order?: boolean | 'asc' | 'desc'
}

declare type TableOptions = {
  page: number
  itemsPerPage: number
  sortBy: SortItem[]
  groupBy: SortItem[]
  search?: string
}
