import axios, { type AxiosPromise } from "axios"

export const fetchOffices = async (): AxiosPromise<any> => {
    return await axios.get(`https://theomnia.ru/api/offices`)
}

export const createOffice = async (input: {
    name: string,
    address: string,
    numberOfJobs: number,
    numberLevel: number,
}): AxiosPromise<any> => {
    return await axios.post('https://theomnia.ru/api/offices/create', {
        name: input.name,
        address: input.address,
        numberOfJobs: input.numberOfJobs,
        numberLevel: input.numberLevel,
    })
}