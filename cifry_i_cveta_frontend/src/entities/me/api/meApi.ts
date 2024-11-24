import axios, { type AxiosPromise } from "axios"

export const fetchMe = async (): AxiosPromise<any> => {
    return await axios.get(`https://theomnia.ru/api/user/current`)
}

export const auth = async () => {
    return await fetch(`https://theomnia.ru/api/auth/keycloak/connect`, {
        method: "GET",
        redirect: 'follow'
    }).then((resp) => {
        window.location.href = resp.url
    })
}

export const logout = async () => {
    return await fetch(`https://theomnia.ru/api/auth/keycloak/logout`, {
        method: "GET",
        redirect: 'follow'
    }).then((resp) => {
        console.log(resp)
        window.location.href = resp.url
    })
}