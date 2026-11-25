@php
$latestAssignment = $booking->assignments
->sortByDesc('id')
->first();

$canAssign = $booking->status === 'pending' && (
!$latestAssignment ||
$latestAssignment->status === 'rejected' ||
$latestAssignment->status === 'reassigned' ||
(
$latestAssignment->status === 'accepted' &&
$latestAssignment->admin_status === 'rejected'
)
);

$statusLabel = 'Belum Ditugaskan';
$statusClass = 'status-pending';
$filterStatus = 'pending';

if ($booking->status === 'rejected') {
$statusLabel = 'Pesanan Ditolak';
$statusClass = 'status-rejected';
$filterStatus = 'rejected';

} elseif (
$booking->status === 'completed' ||
($latestAssignment && $latestAssignment->status === 'completed')
) {
$statusLabel = 'Selesai';
$statusClass = 'status-completed';
$filterStatus = 'completed';

} elseif ($latestAssignment) {

if (
$latestAssignment->status === 'pending' ||
$latestAssignment->status === 'reassigned'
) {
$statusLabel = $latestAssignment->status === 'reassigned'
? 'Ditugaskan Ulang'
: 'Menunggu Terapis';

$statusClass = 'status-pending';
$filterStatus = 'pending';

} elseif ($latestAssignment->status === 'rejected') {
$statusLabel = 'Ditolak Terapis';
$statusClass = 'status-rejected';
$filterStatus = 'rejected';

} elseif ($latestAssignment->status === 'accepted') {

if ($latestAssignment->admin_status === 'pending') {
$statusLabel = 'Menunggu Persetujuan Admin';
$statusClass = 'status-pending';
$filterStatus = 'pending';

} elseif ($latestAssignment->admin_status === 'approved') {
$statusLabel = 'Disetujui';
$statusClass = 'status-approved';
$filterStatus = 'approved';

} elseif ($latestAssignment->admin_status === 'rejected') {
$statusLabel = 'Ditolak Admin';
$statusClass = 'status-rejected';
$filterStatus = 'rejected';
}
}
}
@endphp

<tr
    data-booking-id="{{ $booking->id }}"
    data-status="{{ $filterStatus }}"
    data-place="{{ $booking->place === 'home' ? 'home' : 'clinic' }}"
    data-search="{{ strtolower(($booking->user->name ?? '') . ' ' . $booking->treatment . ' ' . ($booking->phone ?? '')) }}">

    <!-- CUSTOMER + DETAIL -->
    <td>
        <b>{{ $booking->user->name ?? '-' }}</b>
        <small>{{ $booking->phone ?? '-' }}</small>

        <template class="detail">

            <span class="status {{ $statusClass }}">
                {{ $statusLabel }}
            </span>

            <h2>{{ $booking->user->name ?? '-' }}</h2>
            <p class="sub">{{ $booking->treatment }}</p>

            <!-- TREATMENT & HARGA -->
            <div class="detail-group">
                <h3>Treatment</h3>

                <div class="detail-row">
                    <span>Treatment</span>
                    <span>{{ $booking->treatment }}</span>
                </div>

                <div class="detail-row">
                    <span>Treatment Price</span>
                    <span>Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="detail-row">
                    <span>Service Fee</span>
                    <span>Rp{{ number_format($booking->service_fee ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="detail-row total">
                    <span>Total Price</span>
                    <span>Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- CUSTOMER -->
            <div class="detail-group">
                <h3>Customer</h3>

                <div class="detail-row">
                    <span>Customer</span>
                    <span>{{ $booking->user->name ?? '-' }}</span>
                </div>

                <div class="detail-row">
                    <span>Gender</span>
                    <span>{{ $booking->gender ?? '-' }}</span>
                </div>

                <div class="detail-row">
                    <span>Phone</span>
                    <span>{{ $booking->phone ?? '-' }}</span>
                </div>
            </div>

            <!-- JADWAL & LOKASI -->
            <div class="detail-group">
                <h3>Jadwal &amp; Lokasi</h3>

                <div class="detail-row">
                    <span>Date</span>
                    <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                </div>

                <div class="detail-row">
                    <span>Time</span>
                    <span>{{ substr($booking->booking_time, 0, 5) }}</span>
                </div>

                <div class="detail-row">
                    <span>Location</span>
                    <span>{{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}</span>
                </div>

                <div class="detail-row">
                    <span>Address</span>
                    <span>{{ $booking->place === 'home' ? ($booking->address ?? '-') : 'Klinik CLAIRE' }}</span>
                </div>
            </div>

            <!-- PAYMENT -->
            <div class="detail-group">
                <h3>Payment</h3>

                <div class="detail-row">
                    <span>Payment</span>
                    <span>{{ $booking->payment_method ?? '-' }}</span>
                </div>
            </div>

            <!-- NOTES -->
            <div class="detail-group">
                <h3>Notes</h3>
                <div class="note-box">{{ $booking->notes ?? '-' }}</div>
            </div>

            <!-- ASSIGN THERAPIST -->
            <div class="detail-group">
                <h3>Terapis</h3>

                @if($canAssign)

                <form
                    action="{{ route('booking.assignTherapist', $booking->id) }}"
                    method="POST"
                    class="assign-form">
                    @csrf

                    <select name="therapist_id" required>
                        <option value="">Pilih Terapis</option>

                        @foreach($therapists as $therapist)
                        <option
                            value="{{ $therapist->id }}"
                            {{ $booking->therapist_id == $therapist->id ? 'selected' : '' }}
                            {{ !$therapist->is_available ? 'disabled' : '' }}>
                            {{ $therapist->name }}
                            {{ !$therapist->is_available ? '(Nonaktif)' : '' }}
                        </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-approve">
                        {{ $latestAssignment ? 'Tugaskan Ulang' : 'Simpan' }}
                    </button>
                </form>

                @elseif($latestAssignment && $latestAssignment->status === 'pending')

                <span>Menunggu respons terapis</span>

                @elseif(
                $latestAssignment &&
                $latestAssignment->status === 'accepted' &&
                $latestAssignment->admin_status === 'pending'
                )

                <span>Menunggu keputusan admin</span>

                @else
                -
                @endif
            </div>

            <!-- RIWAYAT PENUGASAN -->

            <div class="detail-group">
                <h3>Riwayat Penugasan Terapis</h3>

                @if($booking->assignments && $booking->assignments->count() > 0)

                @foreach($booking->assignments->sortBy('id') as $assignmentHistory)

                @php
                $historyStatusLabel = match($assignmentHistory->status) {
                'pending' => 'Menunggu respons terapis',
                'accepted' => $assignmentHistory->admin_status === 'approved'
                ? 'Disetujui admin'
                : ($assignmentHistory->admin_status === 'rejected'
                ? 'Ditolak admin'
                : 'Diterima, menunggu admin'),
                'rejected' => 'Terapis menolak tugas',
                'reassigned' => 'Penugasan ulang',
                'completed' => 'Selesai',
                default => ucfirst($assignmentHistory->status ?? 'Tidak diketahui'),
                };

                $historyStatusClass =
                $assignmentHistory->status === 'rejected' ||
                $assignmentHistory->admin_status === 'rejected'
                ? 'status-rejected'
                : (
                ($assignmentHistory->status === 'accepted' &&
                $assignmentHistory->admin_status === 'approved') ||
                $assignmentHistory->status === 'completed'
                ? 'status-approved'
                : 'status-pending'
                );
                @endphp

                <div class="detail-row" style="align-items:flex-start; gap:12px; padding:10px 0; border-bottom:1px solid var(--border, #eee);">

                    <div style="flex:1; min-width:0;">
                        <strong>
                            {{ $assignmentHistory->therapist->name ?? 'Nama terapis tidak tersedia' }}
                        </strong>

                        <small style="display:block; margin-top:4px;">
                            Penugasan #{{ $assignmentHistory->id }}
                        </small>

                        @if($assignmentHistory->created_at)
                        <small style="display:block; margin-top:3px;">
                            Ditugaskan:
                            {{ $assignmentHistory->created_at->format('d M Y, H:i') }}
                        </small>
                        @endif

                        {{-- Waktu respons Worker --}}
                        @if($assignmentHistory->responded_at)
                        <small style="display:block; margin-top:4px;">
                            Direspons:
                            {{ $assignmentHistory->responded_at->format('d M Y, H:i') }}
                        </small>
                        @endif

                        {{-- Alasan penolakan Worker --}}
                        @if(
                        $assignmentHistory->status === 'rejected' &&
                        $assignmentHistory->rejection_reason
                        )
                        <div class="mt-2 p-2 rounded-lg bg-red-50 border border-red-200">
                            <p class="text-xs font-semibold text-red-700">
                                Alasan penolakan:
                            </p>

                            <p class="text-xs text-red-600 mt-1">
                                {{ $assignmentHistory->rejection_reason }}
                            </p>
                        </div>
                        @endif

                    </div>

                    <span class="status {{ $historyStatusClass }}">
                        {{ $historyStatusLabel }}
                    </span>

                </div>

                @endforeach

                @else
                <span>Belum ada penugasan terapis.</span>
                @endif
            </div>


            <!-- ACTION PENUGASAN -->
            <div class="detail-group">
                <h3>Assign Therapist</h3>

                @if($booking->status === 'rejected')

                <span class="t-bad t-bold">Pesanan Ditolak</span>

                @elseif($booking->status === 'completed')

                <span class="t-done t-bold">Selesai</span>

                @elseif($booking->status === 'pending')

                @if($latestAssignment)

                @if($latestAssignment->status === 'pending')

                <span class="t-wait">Menunggu respons terapis</span>

                @elseif($latestAssignment->status === 'rejected')

                <span class="t-bad">Terapis menolak tugas</span>

                @elseif($latestAssignment->status === 'accepted')

                @if($latestAssignment->admin_status === 'pending')

                <form
                    action="{{ route('booking.approve', $booking->id) }}"
                    method="POST"
                    style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-approve">
                        Approve Penugasan
                    </button>
                </form>

                <form
                    action="{{ route('booking.rejectAssignment', $booking->id) }}"
                    method="POST"
                    style="display:inline;"
                    onsubmit="return confirm('Yakin ingin menolak penugasan terapis ini? Customer tetap berstatus Menunggu.');">
                    @csrf
                    <button type="submit" class="btn btn-reject">
                        Reject Penugasan
                    </button>
                </form>

                @elseif($latestAssignment->admin_status === 'approved')

                <span class="t-ok t-bold">Disetujui Admin</span>

                @elseif($latestAssignment->admin_status === 'rejected')

                <span class="t-bad">Ditolak Admin</span>

                @endif
                @endif

                @else
                <span class="t-wait">Belum ada terapis</span>
                @endif

                <form
                    action="{{ route('booking.reject', $booking->id) }}"
                    method="POST"
                    style="margin-top:6px;"
                    onsubmit="return confirm('Yakin ingin menolak pesanan customer ini?');">
                    @csrf
                    <button type="submit" class="btn btn-reject">
                        Tolak Pesanan
                    </button>
                </form>

                @elseif($booking->status === 'approved')

                <span class="t-ok t-bold">Disetujui</span>

                @endif
            </div>

            <!-- ACTION / STATUS INFO -->
            <div class="detail-group">
                <h3>Action</h3>

                @if($booking->status === 'rejected')

                <span class="t-bad t-bold">Pesanan customer ditolak.</span>

                @elseif(
                $booking->status === 'completed' ||
                ($latestAssignment && $latestAssignment->status === 'completed')
                )

                <span class="t-done t-bold">Treatment telah selesai.</span>

                @elseif(
                $latestAssignment &&
                $latestAssignment->status === 'accepted' &&
                $latestAssignment->admin_status === 'approved'
                )

                <span class="t-ok t-bold">
                    Terapis disetujui. Treatment menunggu pelaksanaan.
                </span>

                @elseif(
                $latestAssignment &&
                $latestAssignment->status === 'accepted' &&
                $latestAssignment->admin_status === 'pending'
                )

                <span class="t-wait">
                    Menunggu keputusan admin atas penugasan.
                </span>

                @elseif(
                $latestAssignment &&
                $latestAssignment->status === 'accepted' &&
                $latestAssignment->admin_status === 'rejected'
                )

                <span class="t-bad">
                    Penugasan ditolak admin. Silakan tugaskan ulang.
                </span>

                @elseif($latestAssignment && $latestAssignment->status === 'rejected')

                <span class="t-bad">
                    Terapis menolak penugasan. Silakan tugaskan ulang.
                </span>

                @else

                <span class="t-wait">
                    Booking belum memiliki penugasan terapis.
                </span>

                @endif
            </div>

        </template>
    </td>

    <!-- TREATMENT -->
    <td>
        {{ $booking->treatment }}
        <small>
            Rp{{ number_format($booking->price ?? 0, 0, ',', '.') }}
        </small>
    </td>

    <!-- DATE -->
    <td>
        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
        <small>{{ substr($booking->booking_time, 0, 5) }}</small>
    </td>

    <!-- LOCATION -->
    <td>
        {{ $booking->place === 'home' ? 'Home Service' : 'Klinik' }}
        <small>{{ $booking->payment_method ?? '-' }}</small>
    </td>

    <!-- STATUS -->
    <td>
        <span class="status {{ $statusClass }}">
            {{ $statusLabel }}
        </span>
    </td>

    <!-- THERAPIST -->
    <td>
        @if($latestAssignment && $latestAssignment->therapist)

        @if($latestAssignment->status === 'rejected')

        <small class="status status-rejected">
            Terapis menolak tugas
        </small>

        @else

        @if($latestAssignment->status === 'pending')

        <small class="status status-pending">
            Menunggu respons
        </small>

        @elseif($latestAssignment->status === 'accepted')

        <small class="status {{ $latestAssignment->admin_status === 'approved' ? 'status-approved' : ($latestAssignment->admin_status === 'rejected' ? 'status-rejected' : 'status-pending') }}">
            {{ $latestAssignment->admin_status === 'approved'
                            ? 'Disetujui Admin'
                            : ($latestAssignment->admin_status === 'rejected'
                                ? 'Ditolak Admin'
                                : 'Menunggu Admin') }}
        </small>

        @elseif($latestAssignment->status === 'completed')

        <small class="status status-completed">
            Selesai
        </small>

        @else

        <small>{{ ucfirst($latestAssignment->status) }}</small>

        @endif

        @endif

        @else
        <span>-</span>
        @endif
    </td>

    <!-- TOTAL PRICE -->
    <td class="num price">
        Rp{{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
    </td>

</tr>