import type { EWorkspaceStatuses } from '../enums'

export interface IWorkspace {
    workspaceId: number
    employeeId: number
    workspaceStatus: EWorkspaceStatuses
}
