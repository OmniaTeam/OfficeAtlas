import { baseApi } from "@/shared";
import axios, { type AxiosPromise } from "axios";

export const uploadEmployees = async (officeId: number, formData: FormData): AxiosPromise<any> => {
    try {
        const response = await axios.post(`https://theomnia.ru/service/office/${officeId}/users/upload`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data', // Указываем тип контента
            },
        });
        return response.data; // Возвращаем данные ответа
    } catch (error) {
        // Обработка ошибок
        console.error("Ошибка при загрузке файла:", error);
        throw error; // Пробрасываем ошибку дальше
    }
};

interface QueryParams {
    pagination?: {
        perPage?: number
        currentPage?: number
    }
    filter?: {}
}

export const fetchEmployees = (queryParams?: QueryParams): AxiosPromise<any[]> => {
    const params: any = {}

    if (queryParams) {
        if (queryParams.pagination) {
            if (queryParams.pagination.perPage !== undefined) {
                params['pagination[perPage]'] = queryParams.pagination.perPage
            }
            if (queryParams.pagination.currentPage !== undefined) {
                params['pagination[currentPage]'] = queryParams.pagination.currentPage
            }
        }

        if (queryParams.filter) {
            Object.keys(queryParams.filter).forEach((key) => {
                const value = queryParams.filter![key as keyof typeof queryParams.filter]
                if (value !== undefined) {
                    params[`filter[${key}]`] = value
                }
            })
        }
    }

    return baseApi.get(`/employee`, { params })
}

export const createEmployee = async (officeId: number, employeeFio: string, employeeSpec: string, employeeEmail: string, employeeLink: string, employeePhone: string, employeeDepartment: string, employeeRole: string) => {
    try {
        const params = {
            fio: employeeFio,
            specialization: employeeSpec,
            department: employeeDepartment,
            phone: employeePhone,
            link: employeeLink,
            email: employeeEmail,
            role: employeeRole
        }

        const response = axios.post(`https://theomnia.ru/service/office/${officeId}/users`, params)

        return response
    } catch (error) {
        console.error(error)
    }
}