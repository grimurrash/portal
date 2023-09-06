import { defineStore } from 'pinia'
import type { WordCloudParams } from '@/views/word-cloud/types'
import type { WordCloudProperties } from '@/db/types'
import { paginateArray } from '@/db/utils'

const wordClouds: WordCloudProperties[] = [
  {
    id: 1,
    event: 'Тест',
    question: 'Как дела?',
    creator: 'Иванов Иван',
    cloudLink: 'www.cloud-link.com',
    questionLink: 'www.question-link.com',
    numberOfResponses: 0,
    textColor: 'color1',
    uniqueCheckbox: false,
    wordCloudTitle: 'Облако слов',
    backgroundImage: 'https://portal.cpvs.moscow/public/images/backgroud.svg',
    minTextSize: 30,
    maxTextSize: 120,
    numberOfResponsesCheckbox: false,
    numberOfResponsesSize: 40,
    textRotationAngle: 0,
  },
  {
    id: 2,
    event: 'xТест',
    question: 'xКак дела?',
    creator: 'Петров Петр',
    cloudLink: 'www.cloud-link.com',
    questionLink: 'www.question-link.com',
    numberOfResponses: 1,
    textColor: 'color1',
    uniqueCheckbox: false,
    wordCloudTitle: 'Облако слов',
    backgroundImage: 'https://portal.cpvs.moscow/public/images/backgroud.svg',
    minTextSize: 30,
    maxTextSize: 120,
    numberOfResponsesCheckbox: false,
    numberOfResponsesSize: 20,
    textRotationAngle: 0,
  },
]

export const useWordCloudStore = defineStore('WordCloudStore', {
  actions: {

    // 👉 Fetch word clouds data
    // eslint-disable-next-line sonarjs/cognitive-complexity
    fetchWordClouds(params: WordCloudParams) {
      const q = params.q
      const options = params.options

      const { sortBy = '', itemsPerPage = 10, page = 1 } = options

      const queryLower = q.toLowerCase()

      // filter word clouds
      let filteredWordClouds = wordClouds.filter(wordCloud => (
        wordCloud.event.toLowerCase().includes(queryLower)
        || wordCloud.question.toLowerCase().includes(queryLower)
        || wordCloud.creator.toLowerCase().includes(queryLower))).reverse()

      // sort departments
      const sort = JSON.parse(JSON.stringify(sortBy))
      if (sort.length && sort[0]?.key === 'event') {
        filteredWordClouds = filteredWordClouds.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.event.localeCompare(b.event)
          else
            return b.event.localeCompare(a.event)
        })
      }
      if (sort.length && sort[0]?.key === 'question') {
        filteredWordClouds = filteredWordClouds.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.question.localeCompare(b.question)
          else
            return b.question.localeCompare(a.question)
        })
      }
      if (sort.length && sort[0]?.key === 'creator') {
        filteredWordClouds = filteredWordClouds.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.creator.localeCompare(b.creator)
          else
            return b.creator.localeCompare(a.creator)
        })
      }
      if (sort.length && sort[0]?.key === 'numberOfResponses') {
        filteredWordClouds = filteredWordClouds.sort((a, b) => {
          if (sort[0]?.order === 'asc')
            return a.numberOfResponses - b.numberOfResponses
          else
            return b.numberOfResponses - a.numberOfResponses
        })
      }

      const totalWordClouds = filteredWordClouds.length
      const totalPages = Math.ceil(totalWordClouds / itemsPerPage)

      return {
        wordClouds: paginateArray(filteredWordClouds, itemsPerPage, page),
        totalPages,
        totalWordClouds,
        page: page > Math.ceil(totalWordClouds / itemsPerPage) ? 1 : page,
      }
    },

    // 👉 Add word cloud
    addWordCloud(wordCloudData: WordCloudProperties) {
      wordClouds.push(wordCloudData)

      return [200]
    },

    // 👉 Delete word cloud
    deleteWordCloud(id: number) {
      const wordCloudIndex = wordClouds.findIndex(e => e.id === id)

      if (wordCloudIndex >= 0) {
        wordClouds.splice(wordCloudIndex, 1)

        return [200]
      }

      return [400]
    },
  },
})
