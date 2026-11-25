@php
$booking = $assignment->booking;
$customer = $booking->user ?? null;

$avatarColors = ['#ee8b7c', '#8c8cf0', '#7cc255', '#5fb0d4'];

$avatarColor = $avatarColors[
($booking->id ?? 0) % count($avatarColors)
];

$customerName = $customer->name ?? 'Customer';
$initial = strtoupper(mb_substr($customerName, 0, 1));

$photoPath = $customer->photo ?? null;
$photoUrl = null;

if ($photoPath) {
if (\Illuminate\Support\Str::startsWith($photoPath, ['http://', 'https://'])) {
$photoUrl = $photoPath;
} elseif (\Illuminate\Support\Str::startsWith($photoPath, 'storage/')) {
$photoUrl = asset($photoPath);
} elseif (file_exists(public_path(ltrim($photoPath, '/')))) {
$photoUrl = asset(ltrim($photoPath, '/'));
} else {
$photoUrl = asset('storage/' . ltrim($photoPath, '/'));
}
}
@endphp

<div class="incoming-card" data-assignment-id="{{ $assignment->id }}">

    <div class="person">
        <div class="avatar" style="background: {{ $avatarColor }};">
            {{ $initial }}

            @if($photoUrl)
            <img
                src="{{ $photoUrl }}"
                alt="{{ $customerName }}"
                onerror="this.remove()">
            @endif
        </div>

        <div>
            <b>{{ $customerName }}</b>
            <small>
                {{ $booking->place ?? '-' }}
                ·
                {{ $booking->phone ?? '-' }}
            </small>
        </div>
    </div>

    <div class="job-info">
        <div>
            <span>Treatment</span>
            <b>{{ $booking->treatment ?? '-' }}</b>
        </div>

        <div>
            <span>Tanggal</span>
            <b>
                {{ $booking->booking_date
                    ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y')
                    : '-' }}
            </b>
        </div>

        <div>
            <span>Jam</span>
            <b>{{ $booking->booking_time ?? '-' }}</b>
        </div>

        <div>
            <span>Alamat</span>
            <b>{{ $booking->address ?? '-' }}</b>
        </div>
    </div>

    <div class="incoming-bottom">

        @if($assignment->status === 'pending')

        <span>Menunggu Respons</span>

        <div class="incoming-actions">

            <form
                action="{{ route('therapist.assignment.accept', $assignment->id) }}"
                method="POST">
                @csrf
                <button type="submit">Terima</button>
            </form>

            <form
                action="{{ route('therapist.assignment.reject', $assignment->id) }}"
                method="POST">
                @csrf

                <textarea
                    name="rejection_reason"
                    placeholder="Alasan menolak pekerjaan..."
                    required></textarea>

                <button type="submit">Tolak</button>
            </form>

        </div>

        @elseif($assignment->status === 'rejected')

        <span>Ditolak</span>
        <p>{{ $assignment->rejection_reason }}</p>

        @endif

    </div>

</div>