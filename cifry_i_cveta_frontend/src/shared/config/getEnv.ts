export const getEnv = (key: string) => {
    if (import.meta.env[`VITE_APP_${key}`] === undefined) {
        if (key === 'BASE_URL') {
            return 'https://stage.raction.sandbox.crmbox.skillum.ru/api/v1'
        } else {
            throw new Error(`Env variable ${key} is required`)
        }
    }
    return import.meta.env[`VITE_APP_${key}`] || ''
}
