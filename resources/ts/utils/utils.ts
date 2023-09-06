export const paginationMeta = computed(() => {
  return <T extends { page: number; itemsPerPage: number }>(options: T, total: number) => {
    const start = (options.page - 1) * options.itemsPerPage + 1
    const end = Math.min(options.page * options.itemsPerPage, total)

    return `Показаны ${start} c ${end} по ${total} записей`
  }
})

export const tableOptionsToObject = (options: TableOptions) => {
  let sortBy
  if (options.sortBy.length > 0) {
    sortBy = options.sortBy[0]
  }

  return {
    search: options.search,
    page: options.page,
    per_page: options.itemsPerPage,
    sort_column: sortBy?.key ?? undefined,
    sort_order: sortBy?.order ?? undefined,
  }
}
