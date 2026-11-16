<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notifications</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#f7f8fa,#eef2f5);
    min-height:100vh;
    padding:40px 20px;
}

.container{
    max-width:950px;
    margin:auto;
}

/* HEADER */

.header{
    background:white;
    padding:25px 30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:25px;
}

.header h1{
    font-size:28px;
    color:#24442f;
    font-weight:700;
}

.header p{
    color:#777;
    margin-top:5px;
    font-size:14px;
}

.back-btn{
    text-decoration:none;
    background:#24442f;
    color:white;
    padding:12px 20px;
    border-radius:12px;
    font-size:14px;
    transition:.3s;
}

.back-btn:hover{
    transform:translateY(-2px);
}

/* NOTIFICATION CARD */

.notification{
    background:white;
    border-radius:18px;
    margin-bottom:18px;
    overflow:hidden;

    box-shadow:0 8px 25px rgba(0,0,0,.06);

    display:flex;
    transition:.3s;
}

.notification:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 35px rgba(0,0,0,.1);
}

.accent{
    width:6px;
    background:#24442f;
}

.content{
    flex:1;
    padding:22px;
}

.top-row{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
}

.treatment{
    font-size:18px;
    font-weight:600;
    color:#222;
}

.datetime{
    margin-top:8px;
    color:#777;
    font-size:14px;
}

/* STATUS */

.status{
    padding:8px 16px;
    border-radius:30px;
    color:white;
    font-size:12px;
    font-weight:600;
    letter-spacing:.5px;
    text-transform:uppercase;
}

.pending{
    background:#f59e0b;
}

.approved{
    background:#16a34a;
}

.rejected{
    background:#dc2626;
}

.completed{
    background:#2563eb;
}

/* ACTION */

.actions{
    margin-top:20px;
    display:flex;
    justify-content:flex-end;
}

.delete-btn{
    background:#f3f4f6;
    border:none;
    color:#444;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
    transition:.3s;
    font-size:13px;
}

.delete-btn:hover{
    background:#dc2626;
    color:white;
}

/* EMPTY */

.empty{
    background:white;
    padding:60px 30px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.empty h3{
    color:#24442f;
    margin-bottom:10px;
}

.empty p{
    color:#777;
}

/* MOBILE */

@media(max-width:768px){

    .header{
        flex-direction:column;
        align-items:flex-start;
        gap:20px;
    }

    .header h1{
        font-size:24px;
    }

    .top-row{
        flex-direction:column;
        gap:12px;
    }

    .status{
        width:fit-content;
    }

}

</style>
</head>
<body>

<div class="container">

    <div class="header">

        <div>
            <h1>Notifications</h1>
            <p>Monitor all updates related to your treatment bookings.</p>
        </div>

        <a href="/dashboard" class="back-btn">
            Back to Dashboard
        </a>

    </div>

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
                        {{ $b->booking_date }} • {{ $b->booking_time }}
                    </div>
                </div>

                <span class="status {{ $b->status }}">
                    {{ ucfirst($b->status) }}
                </span>

            </div>

            <div class="actions">

                <form method="POST"
                      action="{{ route('notifications.hide', $b->id) }}">
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