export default {
    async get (url) {
        const response = await fetch(url)

        const json = await response.json()
        return {
            status: response.status,
            ok: response.ok,
            data: json
        }
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
    },
    async delete (url) {
        const method = "DELETE";
        const headers = {
            'X-XSRF-TOKEN': window.$cookies.get('XSRF-TOKEN')
        }
        const response = await fetch(url, {
            method,
            headers
        })
        return {
            status: response.status,
            ok: response.ok,
        }
    }
}