
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
   .listen('.booking.created', async (event) => {
    console.log('Booking baru diterima:', event.booking);

    try {
        const bookingId = event.booking.id;

        // URL endpoint Laravel
        const urlTemplate = document.querySelector('#bookingRows')
            ?.dataset.rowUrl;

        if (!urlTemplate) {
            throw new Error('URL booking row tidak ditemukan.');
        }

        const url = urlTemplate.replace('__ID__', bookingId);

        // Meminta HTML booking terbaru dari Laravel
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil data booking.');
        }

        const data = await response.json();

        const bookingRows = document.getElementById('bookingRows');

        // Hapus pesan jika tabel sebelumnya kosong
        document.getElementById('emptyBookingRow')?.remove();

        // Hindari memasukkan booking yang sama dua kali
        const existingRow = bookingRows.querySelector(
            `tr[data-booking-id="${bookingId}"]`
        );

        if (!existingRow) {
            const temporaryContainer = document.createElement('tbody');
            temporaryContainer.innerHTML = data.html.trim();

            const newRow = temporaryContainer.firstElementChild;

            if (newRow) {
                newRow.dataset.bookingId = bookingId;
                bookingRows.prepend(newRow);
            }
        }

        // Perbarui statistik
        document.getElementById('totalBookingsCount').textContent =
            data.totalBookings;

        document.getElementById('pendingBookingsCount').textContent =
            data.pendingBookings;

        document.getElementById('completedBookingsCount').textContent =
            data.completedBookings;

        // Perbarui badge sidebar
        const badge = document.getElementById('pendingBookingBadge');

        if (badge) {
            badge.textContent = data.pendingBookings;
            badge.style.display = data.pendingBookings > 0 ? '' : 'none';
        }

        // Terapkan kembali filter dan pencarian
        if (typeof window.applyBookingFilter === 'function') {
            window.applyBookingFilter();
        }

        console.log('Booking berhasil ditambahkan ke tabel.');

    } catch (error) {
        console.error('Gagal memperbarui tabel booking:', error);
    }
});
