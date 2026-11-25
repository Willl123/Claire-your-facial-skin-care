
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

console.log('JavaScript Echo berhasil dimuat');

// =====================================================
// KONFIGURASI LARAVEL REVERB
// =====================================================

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

// =====================================================
// FUNGSI MEMPERBARUI BARIS BOOKING ADMIN
// =====================================================

async function refreshBookingRow(bookingId) {
    const bookingRows = document.getElementById('bookingRows');

    if (!bookingRows) return;

    try {
        const urlTemplate = bookingRows.dataset.rowUrl;

        if (!urlTemplate) {
            throw new Error('URL booking row tidak ditemukan.');
        }

        const url = urlTemplate.replace('__ID__', bookingId);

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Response booking:', errorText);
            throw new Error(`Gagal mengambil data booking. HTTP ${response.status}`);
        }

        const data = await response.json();

        const temporaryContainer = document.createElement('tbody');
        temporaryContainer.innerHTML = data.html.trim();

        const newRow = temporaryContainer.firstElementChild;

        if (!newRow) {
            throw new Error('HTML baris booking tidak ditemukan.');
        }

        newRow.dataset.bookingId = bookingId;

        const existingRow = bookingRows.querySelector(
            `tr[data-booking-id="${bookingId}"]`
        );

        if (existingRow) {
            existingRow.replaceWith(newRow);
        } else {
            document.getElementById('emptyBookingRow')?.remove();
            bookingRows.prepend(newRow);
        }

        // Perbarui statistik Admin
        const totalCount = document.getElementById('totalBookingsCount');
        const pendingCount = document.getElementById('pendingBookingsCount');
        const completedCount = document.getElementById('completedBookingsCount');

        if (totalCount) {
            totalCount.textContent = data.totalBookings;
        }

        if (pendingCount) {
            pendingCount.textContent = data.pendingBookings;
        }

        if (completedCount) {
            completedCount.textContent = data.completedBookings;
        }

        // Perbarui badge sidebar
        const badge = document.getElementById('pendingBookingBadge');

        if (badge) {
            badge.textContent = data.pendingBookings;
            badge.style.display = data.pendingBookings > 0 ? '' : 'none';
        }

        // Terapkan ulang filter
        if (typeof window.applyBookingFilter === 'function') {
            window.applyBookingFilter();
        }

        console.log('Baris booking berhasil diperbarui:', bookingId);

    } catch (error) {
        console.error('Gagal memperbarui booking:', error);
    }
}

// =====================================================
// 1. ADMIN MENERIMA BOOKING BARU
// =====================================================

if (document.getElementById('bookingRows')) {

    window.Echo.private('admin.bookings')
        .subscribed(() => {
            console.log('Terhubung ke channel admin.bookings');
        })
        .error((error) => {
            console.error('Gagal terhubung ke admin.bookings:', error);
        })
        .listen('.booking.created', async (event) => {
            console.log('Booking baru diterima:', event.booking);

            await refreshBookingRow(event.booking.id);
        });

    // =================================================
    // 2. ADMIN MENERIMA RESPONS PENUGASAN WORKER
    // =================================================

    window.Echo.private('admin.assignments')
        .subscribed(() => {
            console.log('Terhubung ke channel admin.assignments');
        })
        .error((error) => {
            console.error('Gagal terhubung ke admin.assignments:', error);
        })
        .listen('.assignment.responded', async (event) => {
            console.log('Respons penugasan diterima:', event.assignment);

            await refreshBookingRow(event.assignment.booking_id);
        });
}

// =====================================================
// 3. WORKER MENERIMA PENUGASAN BARU SECARA REALTIME
// =====================================================

const therapistDashboard = document.getElementById('therapistDashboard');

if (therapistDashboard && window.Echo) {

    const therapistId = therapistDashboard.dataset.therapistId;
    const cardUrlTemplate = therapistDashboard.dataset.cardUrl;

    if (!therapistId || !cardUrlTemplate) {
        console.error('ID Worker atau URL kartu tidak ditemukan.');
    } else {

        window.Echo.private(`worker.assignments.${therapistId}`)
            .subscribed(() => {
                console.log('Worker berhasil terhubung ke channel assignment');
            })
            .error((error) => {
                console.error('Gagal terhubung ke channel assignment:', error);
            })
            .listen('.assignment.created', async (event) => {

                console.log('Assignment baru diterima:', event.assignment);

                const track = document.getElementById('incomingTrack');
                const countElement = document.getElementById('incomingPendingCount');

                if (!track) {
                    console.error('Elemen incomingTrack tidak ditemukan.');
                    return;
                }

                const assignmentId = event.assignment?.id;

                if (!assignmentId) {
                    console.error('ID assignment tidak ditemukan:', event.assignment);
                    return;
                }

                // Hindari kartu yang sama muncul dua kali
                if (track.querySelector(`[data-assignment-id="${assignmentId}"]`)) {
                    console.log('Assignment sudah ada:', assignmentId);
                    return;
                }

                try {
                    const url = cardUrlTemplate.replace(
                        '__ID__',
                        assignmentId
                    );

                    console.log('Mengambil kartu dari:', url);

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!response.ok) {
                        const errorText = await response.text();

                        console.error('HTTP Status:', response.status);
                        console.error('Response Server:', errorText);

                        throw new Error(
                            `Gagal mengambil kartu penugasan. HTTP ${response.status}`
                        );
                    }

                    const responseData = await response.json();

                    console.log('Respons kartu dari server:', responseData);

                    if (!responseData.html) {
                        throw new Error('HTML kartu tidak ditemukan dalam response.');
                    }

                    const temporaryContainer = document.createElement('div');

                    temporaryContainer.innerHTML = responseData.html.trim();

                    const newCard = temporaryContainer.firstElementChild;

                    if (!newCard) {
                        throw new Error('HTML kartu penugasan kosong.');
                    }

                    // Pastikan ID assignment terpasang
                    newCard.dataset.assignmentId = assignmentId;

                    // Hapus pesan kosong
                    document.getElementById('emptyIncoming')?.remove();

                    // Tambahkan kartu baru ke bagian paling atas
                    track.prepend(newCard);

                    // Perbarui jumlah pekerjaan masuk
                    if (countElement) {
                        const totalPending = track.querySelectorAll(
                            '.incoming-card[data-assignment-id]'
                        ).length;

                        countElement.textContent =
                            `${totalPending} Menunggu Respons`;
                    }

                    console.log(
                        'Kartu pekerjaan baru berhasil ditampilkan:',
                        assignmentId
                    );

                } catch (error) {
                    console.error(
                        'Gagal menampilkan penugasan baru:',
                        error
                    );

                    console.error('Detail assignment:', event.assignment);
                    console.error('URL kartu:', cardUrlTemplate);
                }
            });
    }
}

console.log('Echo siap digunakan untuk booking, penugasan, dan chat.');
