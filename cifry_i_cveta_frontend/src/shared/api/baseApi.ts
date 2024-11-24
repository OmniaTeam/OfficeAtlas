import { getEnv } from '../config'

import axios from 'axios'

export const baseApi = axios.create({
    baseURL: getEnv('BASE_URL'),
})
