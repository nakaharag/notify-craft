import axios from 'axios'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content')!

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    },
})

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

axios.interceptors.request.use(config => {
    const token = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1]

    if (token) {
        config.headers!['X-XSRF-TOKEN'] = decodeURIComponent(token)
    }

    return config
})
