import type { ESpecs } from '../enums'

export interface IEmployee {
    employeeId: number
    employeeFio: string
    employeeSpec: ESpecs
    employeeDepartment: string
    employeePhone: string
    employeeLink: string
    employeeEmail: string
}
