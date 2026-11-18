
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Terapis - CLAIRE</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f5f7f5;
            color: #26352a;
        }

        .container {
            max-width: 1400px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 26px;
        }

        .header p {
            margin: 0;
            color: #777;
        }

        .back-button,
        .month-button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .back-button {
            background: #24442f;
            color: white;
        }

        .calendar-card {
            background: white;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .calendar-header h2 {
            margin: 0;
            font-size: 22px;
            text-transform: capitalize;
        }

        .month-navigation {
            display: flex;
            gap: 8px;
        }

        .month-button {
            background: #edf2ed;
            color: #24442f;
        }

        .month-button:hover {
            background: #dce8dd;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            border-top: 1px solid #e5e9e5;
            border-left: 1px solid #e5e9e5;
        }

        .weekday {
            padding: 13px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            background: #f5f7f5;
            border-right: 1px solid #e5e9e5;
            border-bottom: 1px solid #e5e9e5;
        }

        .calendar-day {
            min-height: 145px;
            padding: 8px;
            border-right: 1px solid #e5e9e5;
            border-bottom: 1px solid #e5e9e5;
            min-width: 0;
        }

        .calendar-day.other-month {
            background: #fafafa;
            color: #aaa;
        }

        .day-number {
            display: inline-flex;
            width: 27px;
            height: 27px;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .day-number.today {
            background: #24442f;
            color: white;
        }

        .booking-event {
            background: #e7f0e8;
            border-left: 3px solid #24442f;
            padding: 7px;
            margin-bottom: 6px;
            border-radius: 4px;
            font-size: 11px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .booking-event strong {
            display: block;
            color: #24442f;
            margin-bottom: 2px;
        }

        .booking-event span {
            display: block;
            color: #536458;
        }

        .therapist-status {
            display: inline-block;
            margin-top: 3px;
            padding: 2px 5px;
            border-radius: 10px;
            font-size: 10px;
        }

        .active {
            background: #d4edda;
            color: #155724;
        }

        .inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .empty-message {
            padding: 35px;
            text-align: center;
            color: #777;
        }

        .therapist-list {
            margin-top: 22px;
            padding: 20px;
            background: white;
            border-radius: 12px;
        }

        .therapist-list h3 {
            margin-top: 0;
        }

        .therapist-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .therapist-item {
            padding: 9px 13px;
            border: 1px solid #e5e9e5;
            border-radius: 6px;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .calendar-card {
                padding: 10px;
                overflow-x: auto;
            }

            .calendar-grid {
                min-width: 700px;
            }

            .calendar-day {
                min-height: 120px;
            }

            .calendar-header h2 {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Kalender Jadwal Terapis</h1>
            <p>Kelola dan pantau jadwal treatment seluruh terapis CLAIRE.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="back-button">
            Kembali ke Dashboard
        </a>
    </div>

    

    <div class="calendar-card">

        <div class="calendar-header">
            <h2>
                {{ $currentMonth->locale('id')->translatedFormat('F Y') }}
            </h2>

            <div class="month-navigation">
                <a href="{{ route('admin.therapistSchedules', ['month' => $previousMonth]) }}"
                   class="month-button">
                    &laquo; Sebelumnya
                </a>

                <a href="{{ route('admin.therapistSchedules', ['month' => $nextMonth]) }}"
                   class="month-button">
                    Berikutnya &raquo;
                </a>
            </div>
        </div>

        <div class="calendar-grid">

            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $weekday)
                <div class="weekday">
                    {{ $weekday }}
                </div>
            @endforeach

            @foreach($calendarDays as $day)

                @php
                    $dateKey = $day->format('Y-m-d');
                    $dayBookings = $bookings->get($dateKey, collect());
                    $isCurrentMonth = $day->month === $currentMonth->month;
                    $isToday = $day->isToday();
                @endphp

                <div class="calendar-day {{ $isCurrentMonth ? '' : 'other-month' }}">

                    <div class="day-number {{ $isToday ? 'today' : '' }}">
                        {{ $day->day }}
                    </div>

                    @foreach($dayBookings as $booking)

                        <div class="booking-event">

                            <strong>
                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                - {{ $booking->treatment }}
                            </strong>

                            <span>
                                Pelanggan:
                                {{ $booking->user->name ?? 'Tidak tersedia' }}
                            </span>

                            <span>
                                Terapis:
                                {{ $booking->therapist->name ?? 'Tidak tersedia' }}
                            </span>

                            @if($booking->therapist)
                                <span class="therapist-status {{ $booking->therapist->is_available ? 'active' : 'inactive' }}">
                                    {{ $booking->therapist->is_available ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            @endif

                        </div>

                    @endforeach

                </div>

            @endforeach

        </div>

        @if($bookings->isEmpty())
            <div class="empty-message">
                Belum ada jadwal terapis pada bulan ini.
            </div>
        @endif

    </div>

   
    </div>

</div>

</body>
</html>
