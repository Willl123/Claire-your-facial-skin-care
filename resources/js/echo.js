
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

console.log('JavaScript Echo berhasil dimuat');

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

console.log('Echo berhasil dibuat');

window.Echo.private('admin.bookings')
    .subscribed(() => {
        console.log('Berhasil terhubung ke channel admin.bookings');
    })
    .error((error) => {
        console.error('Gagal terhubung ke channel:', error);
    })
    .listen('.booking.created', (event) => {
        console.log('Booking baru diterima:', event.booking);
    });
