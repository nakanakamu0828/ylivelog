export default {
    async get (url) {
        return fetch(url)
    },
    async post (url, data) {
        const method = "POST";
        const body = JSON.stringify(data);
        const headers = {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-XSRF-TOKEN': window.$cookies.get('XSRF-TOKEN')
        }
        const response = await fetch(url, {
            method,
            headers,
            body
        })

        const json = await response.json()
        return {
            status: response.status,
            ok: response.ok,
            data: json
        }
    }
}