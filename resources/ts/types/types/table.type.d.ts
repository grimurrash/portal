declare type SortItem = {
  key: string,
  order?: boolean | 'asc' | 'desc'
}

declare interface TableOptions {
  page: number
  itemsPerPage: number
  sortBy: SortItem[]
  groupBy: SortItem[]
  search: string | undefined
}
