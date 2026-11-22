
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile - CLAIRE</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #f5f7f9;
    min-height: 100vh;
    padding: 30px;
}

.container {
    max-width: 1000px;
    margin: auto;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    color: #24442f;
    background: white;
    padding: 12px 18px;
    border-radius: 12px;
    font-weight: 600;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
    margin-bottom: 20px;
    transition: .3s;
}

.back-btn:hover {
    background: #24442f;
    color: white;
    transform: translateX(-3px);
}

.back-btn svg {
    width: 20px;
    height: 20px;
}

/* HEADER */

.profile-header {
    background: white;
    border-radius: 25px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    text-align: center;
    margin-bottom: 25px;
}

.profile-image {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #24442f;
}

.change-photo {
    display: inline-block;
    margin-top: 12px;
    color: #24442f;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
}

.change-photo:hover {
    text-decoration: underline;
}

.name {
    margin-top: 20px;
    font-size: 28px;
    color: #24442f;
    font-weight: 700;
}

.email {
    color: #777;
    margin-top: 8px;
}

.role-badge {
    display: inline-block;
    margin-top: 12px;
    padding: 7px 16px;
    border-radius: 30px;
    background: #eaf1eb;
    color: #24442f;
    font-size: 13px;
    font-weight: 600;
}

/* INFO */

.info-section {
    background: white;
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.section-title {
    color: #24442f;
    margin-bottom: 20px;
}

.info-box {
    background: #f8f9fb;
    border-radius: 15px;
    padding: 18px;
    margin-bottom: 15px;
}

.info-label {
    color: #888;
    font-size: 13px;
}

.info-value {
    margin-top: 5px;
    font-weight: 600;
    color: #333;
    overflow-wrap: anywhere;
}

/* BUTTON */

.actions {
    margin-top: 25px;
    display: flex;
    gap: 15px;
}

.btn {
    flex: 1;
    border: none;
    border-radius: 14px;
    padding: 15px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: .3s;
}

.logout-btn {
    background: #dc2626;
    color: white;
}

.logout-btn:hover {
    background: #b91c1c;
}

/* ALERT */

.success-message {
    background: #eaf5ec;
    color: #24442f;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.error-message {
    background: #fee2e2;
    color: #991b1b;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
}

/* RESPONSIVE */

@media(max-width:768px) {
    body {
        padding: 15px;
    }

    .profile-header {
        padding: 25px;
    }

    .profile-image {
        width: 120px;
        height: 120px;
    }

    .name {
        font-size: 24px;
    }

    .info-section {
        padding: 22px;
    }

    .actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .back-btn {
        padding: 10px 15px;
        margin-bottom: 15px;
    }
}
</style>
</head>

<body>

<div class="container">

    <!-- BACK -->
    <a href="{{ $dashboardUrl }}" class="back-btn">

        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 19l-7-7 7-7"/>

        </svg>

        Back to Dashboard

    </a>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error-message">
            {{ $errors->first('photo') ?? $errors->first() }}
        </div>
    @endif

    <!-- PROFILE HEADER -->
    <div class="profile-header">

        <img
            id="previewImage"
            src="{{ $user->photo
                ? asset('storage/'.$user->photo)
                : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=24442f&color=fff&size=200' }}"
            class="profile-image"
            alt="Foto Profil">

        <form
            action="{{ route($photoRoute) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <label class="change-photo">
                Change Photo

                <input
                    type="file"
                    name="photo"
                    accept="image/jpeg,image/png,image/webp"
                    hidden
                    onchange="previewAndSubmit(this)">
            </label>

        </form>

        <h2 class="name">{{ $user->name }}</h2>

        <p class="email">{{ $user->email }}</p>

        <span class="role-badge">
            {{ $roleLabel }}
        </span>

    </div>

    <!-- ACCOUNT INFO -->
    <div class="info-section">

        <h3 class="section-title">
            Account Information
        </h3>

        <div class="info-box">
            <div class="info-label">
                Account Status
            </div>

            <div class="info-value">
                Active
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">
                Full Name
            </div>

            <div class="info-value">
                {{ $user->name }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">
                Email Address
            </div>

            <div class="info-value">
                {{ $user->email }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">
                Account Role
            </div>

            <div class="info-value">
                {{ $roleLabel }}
            </div>
        </div>

        <div class="info-box">
            <div class="info-label">
                Member Since
            </div>

            <div class="info-value">
                {{ $user->created_at
                    ? $user->created_at->format('d M Y')
                    : '-' }}
            </div>
        </div>

        <!-- LOGOUT -->
        <div class="actions">

            <form
                id="logoutForm"
                action="{{ route('logout') }}"
                method="POST"
                style="flex:1">

                @csrf

                <button type="submit" class="btn logout-btn">
                    Logout
                </button>

            </form>

        </div>

    </div>

</div>

<script>
function previewAndSubmit(input) {

    if (input.files && input.files[0]) {

        const file = input.files[0];

        // Validasi ukuran foto maksimal 2 MB
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        };

        reader.readAsDataURL(file);

        input.form.submit();
    }
}

document.getElementById("logoutForm").addEventListener("submit", function(e) {

    if (!confirm("Yakin ingin logout?")) {
        e.preventDefault();
    }

});
</script>

</body>
</html>
