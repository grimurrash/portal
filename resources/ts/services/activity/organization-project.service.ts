import type { AxiosResponse } from 'axios'
import axios from '@axios'
import { tableOptionsToObject } from '@/utils/utils'

const baseUrl: string = '/activity/organization-projects'

export const OrganizationProjectService = {
  async create (data: CreateOrganizationProjectRequestDto): Promise<AxiosResponse> {
    return axios.post(baseUrl + '/create', data)
  },

  async mainList (data: OrganizationProjectListRequestDto): Promise<AxiosResponse<PaginateListResponse<OrganizationProjectListItemModel>>> {
    return axios.get<PaginateListResponse<OrganizationProjectListItemModel>>(baseUrl + '/list', {
      params: {
        ...data.filters,
        ...tableOptionsToObject(data.options)
      },
    })
  },

  async moderateList (data: OrganizationProjectListRequestDto): Promise<AxiosResponse<PaginateListResponse<OrganizationProjectListItemModel>>> {
    return axios.get<PaginateListResponse<OrganizationProjectListItemModel>>(baseUrl + '/moderate-list', {
      params: {
        ...data.filters,
        ...tableOptionsToObject(data.options)
      },
    })
  },

  async generalList (data: OrganizationProjectListRequestDto): Promise<AxiosResponse<PaginateListResponse<OrganizationProjectListItemModel>>> {
    return axios.get<PaginateListResponse<OrganizationProjectListItemModel>>(baseUrl + '/general-list', {
      params: {
        ...data.filters,
        ...tableOptionsToObject(data.options)
      },
    })
  },


  async calendar (): Promise<AxiosResponse<OrganizationProjectCalendarItemModel[]>> {
    return axios.get<OrganizationProjectCalendarItemModel[]>(baseUrl + '/calendar')
  },

  async showProject (organizationProjectId: number): Promise<AxiosResponse<OrganizationProjectInfoModelDto>> {
    return axios.get<OrganizationProjectInfoModelDto>(baseUrl + '/' + organizationProjectId)
  },

  async postForModeration (organizationProjectId: number): Promise<AxiosResponse> {
    return axios.put(baseUrl + '/' + organizationProjectId + '/post-for-moderation')
  },

  async moderate (data: UpdateOrganizationProjectRequestDto): Promise<AxiosResponse> {
    return axios.put(baseUrl + '/' + data.id + '/moderate', data)
  },

  async approve (organizationProjectId: number): Promise<AxiosResponse> {
    return axios.put(baseUrl + '/' + organizationProjectId + '/approve')
  },
}
