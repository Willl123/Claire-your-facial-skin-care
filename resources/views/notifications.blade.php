
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications | CLAIRE</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            padding: 40px 20px;
            background: #f5f7f5;
            color: #26332a;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
        }

        /* HEADER */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 28px 32px;
            margin-bottom: 30px;
            background: #fff;
            border: 1px solid #edf0ed;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .04);
        }

        .header h1 {
            color: #24442f;
            font-size: 27px;
            font-weight: 700;
        }

        .header p {
            margin-top: 7px;
            color: #858b86;
            font-size: 13px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 19px;
            background: #24442f;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            transition: .25s;
        }

        .back-btn:hover {
            background: #355c40;
            transform: translateY(-2px);
        }

        /* NOTIFICATION */

        .notification {
            display: flex;
            margin-bottom: 16px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #edf0ed;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .035);
            transition: .25s;
        }

        .notification:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .07);
        }

        .accent {
            flex: 0 0 5px;
            background: #24442f;
        }

        .content {
            flex: 1;
            min-width: 0;
            padding: 23px 25px;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .treatment {
            color: #26332a;
            font-size: 16px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .datetime {
            margin-top: 9px;
            color: #858b86;
            font-size: 12px;
        }

        /* STATUS */

        .status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .4px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .pending {
            color: #a16207;
            background: #fef3c7;
        }

        .approved {
            color: #15803d;
            background: #dcfce7;
        }

        .rejected {
            color: #b91c1c;
            background: #fee2e2;
        }

        .completed {
            color: #1d4ed8;
            background: #dbeafe;
        }

        /* ACTION */

        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #f0f2f0;
        }

        .delete-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #fff;
            color: #737a74;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            transition: .25s;
        }

        .delete-btn:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: #fff;
        }

        /* EMPTY */

        .empty {
            padding: 65px 25px;
            background: #fff;
            border: 1px solid #edf0ed;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .04);
        }

        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 65px;
            height: 65px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #edf3ee;
            color: #24442f;
            font-size: 27px;
        }

        .empty h3 {
            margin-bottom: 9px;
            color: #24442f;
            font-size: 17px;
        }

        .empty p {
            color: #858b86;
            font-size: 12px;
            line-height: 1.8;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {
            body {
                padding: 22px 14px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                padding: 23px 20px;
            }

            .header h1 {
                font-size: 23px;
            }

            .back-btn {
                width: 100%;
            }

            .content {
                padding: 19px 16px;
            }

            .top-row {
                flex-direction: column;
                gap: 13px;
            }

            .treatment {
                font-size: 15px;
            }

            .status {
                font-size: 9px;
            }
        }

        @media (max-width: 400px) {
            body {
                padding: 15px 10px;
            }

            .header {
                padding: 20px 16px;
            }

            .header h1 {
                font-size: 21px;
            }

            .content {
                padding: 17px 13px;
            }

            .datetime {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div>
            <h1>Notifications</h1>
            <p>Monitor all updates related to your treatment bookings.</p>
        </div>

        <a href="/dashboard" class="back-btn">
            &larr; Back to Dashboard
        </a>
    </div>

    <!-- NOTIFICATION LIST -->
    @forelse($bookings as $b)

        <div class="notification">

            <div class="accent"></div>

            <div class="content">

                <div class="top-row">

                    <div>
                        <div class="treatment">
                            {{ $b->treatment }}
                        </div>

                        <div class="datetime">
                            {{ \Carbon\Carbon::parse($b->booking_date)->format('d F Y') }}
                            &nbsp; | &nbsp;
                            {{ \Carbon\Carbon::parse($b->booking_time)->format('H:i') }}
                        </div>
                    </div>

                    <span class="status {{ $b->status }}">
                        {{ ucfirst($b->status) }}
                    </span>

                </div>

                <div class="actions">

                    <form method="POST"
                          action="{{ route('notifications.hide', $b->id) }}"
                          onsubmit="return confirm('Apakah kamu yakin ingin menghapus notifikasi ini?')">

                        @csrf

                        <button type="submit" class="delete-btn">
                            Delete Notification
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="empty">

            <div class="empty-icon">
                &#128276;
            </div>

            <h3>No Notifications Available</h3>

            <p>
                Notifications regarding booking approvals,
                rejections, and completions will appear here.
            </p>

        </div>

    @endforelse

</div>

</body>
</html>
