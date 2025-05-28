export {}

declare global {
    interface Window {
        Pusher: any
        Echo: any
    }
}
declare global {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')!
        .getAttribute('content')!
}
