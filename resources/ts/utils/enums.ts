export const objectToOptions = (cases: object): object[] => {
  const options: object[] = []

  Object.entries(cases).map(function (item) {
    options.push({
      id: item[0],
      label: item[1] as string
    })
  });

  return options
}
