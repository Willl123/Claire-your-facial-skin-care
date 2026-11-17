<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Treatment</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f5f5f5;
padding:40px 20px;
}

.container{
max-width:1100px;
margin:auto;
display:grid;
grid-template-columns:2fr 1fr;
gap:30px;
}

.booking-card,
.summary{
background:white;
padding:35px;
border-radius:20px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.summary{
position:sticky;
top:20px;
height:fit-content;
}

.page-title{
color:#24442f;
margin-bottom:30px;
}

.section-title{
margin:30px 0 20px;
color:#24442f;
font-size:20px;
}

.form-group{
margin-bottom:18px;
}

label{
display:block;
font-weight:600;
margin-bottom:8px;
}

input,
select,
textarea{
width:100%;
padding:14px;
border:1px solid #ddd;
border-radius:10px;
font-size:15px;
}

textarea{
resize:none;
height:100px;
}

.radio-group{
display:flex;
gap:15px;
flex-wrap:wrap;
}

.radio-card{
border:1px solid #ddd;
padding:15px;
border-radius:12px;
cursor:pointer;
flex:1;
}

.radio-card input{
width:auto;
margin-right:8px;
}

button{
width:100%;
padding:16px;
border:none;
border-radius:12px;
margin-top:25px;
background:#24442f;
color:white;
font-size:17px;
cursor:pointer;
}

button:hover{
opacity:.9;
}

.summary h2{
margin-bottom:25px;
}

.summary-item{
display:flex;
justify-content:space-between;
margin-bottom:18px;
}

.total{
margin-top:20px;
padding-top:20px;
border-top:1px solid #eee;
font-size:22px;
font-weight:bold;
color:#24442f;
}

.hidden{
display:none;
}

/* RESPONSIVE */
@media(max-width:900px){
.container{
grid-template-columns:1fr;
}

.summary{
position:relative;
top:0;
}
}
</style>
</head>

<body>

<main class="container">

<section class="booking-card">

<h1 class="page-title">Book Your Treatment</h1>

<form id="bookingForm" action="/booking/store" method="POST">

@csrf

<!-- ================= TREATMENT ================= -->
<h2 class="section-title">Treatment Selection</h2>

<div class="form-group">
<label>Treatment</label>
<select id="treatment" name="treatment">

<option value="Deep Cleansing Facial" data-price="150000">
Deep Cleansing Facial - Rp150.000
</option>

<option value="Acne Facial" data-price="200000">
Acne Facial - Rp200.000
</option>

<option value="Brightening Facial" data-price="250000">
Brightening Facial - Rp250.000
</option>

<option value="Hydrafacial" data-price="300000">
Hydrafacial - Rp300.000
</option>

<option value="Anti Aging Treatment" data-price="350000">
Anti Aging Treatment - Rp350.000
</option>

<option value="Premium Glow Facial" data-price="400000">
Premium Glow Facial - Rp400.000
</option>

</select>
</div>

<!-- ================= PERSONAL INFO ================= -->
<h2 class="section-title">Personal Information</h2>

<div class="form-group">
    <label>Gender</label>

    <div class="radio-group">

        <label class="radio-card">
            <input type="radio" name="gender" value="Male" required>
            Male
        </label>

        <label class="radio-card">
            <input type="radio" name="gender" value="Female">
            Female
        </label>

    </div>
</div>

<div class="form-group">
<label>Phone Number</label>
<input type="text" name="phone" required>
</div>

<!-- ================= SCHEDULE ================= -->
<h2 class="section-title">Schedule</h2>

<div class="form-group">
<label>Date</label>
<input type="date" name="booking_date" id="booking_date" required>
</div>

<div class="form-group">
    <label>Booking Time</label>

    <select name="booking_time" id="booking_time" required>
        <option value="">Pilih Jam</option>
        <option value="07:00">07:00</option>
        <option value="08:00">08:00</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
        <option value="18:00">18:00</option>
        <option value="19:00">19:00</option>
        <option value="20:00">20:00</option>
    </select>

    <small id="timeMessage" style="color:#777;"></small>
</div>

<!-- ================= LOCATION ================= -->
<h2 class="section-title">Treatment Location</h2>

<div class="radio-group">

<label class="radio-card">
<input type="radio" name="place" value="clinic" checked>
At Clinic
</label>

<label class="radio-card">
<input type="radio" name="place" value="home">
At Home
</label>

</div>

<div id="addressBox" class="hidden">

<div class="form-group">
<label>Home Address</label>
<textarea name="address"></textarea>
</div>

</div>

<!-- ================= PAYMENT ================= -->
<h2 class="section-title">Payment Method</h2>

<div class="form-group">
<select name="payment_method">
<option>Bank Transfer</option>
<option>E-Wallet</option>
<option>QRIS</option>
<option>Cash</option>
</select>
</div>

<!-- ================= NOTES ================= -->
<h2 class="section-title">Additional Notes</h2>

<textarea name="notes" placeholder="Allergy, skin condition, etc"></textarea>

<button type="submit">Confirm Booking</button>

</form>

</section>

<!-- ================= SUMMARY ================= -->
<aside class="summary">

<h2>Booking Summary</h2>

<div class="summary-item">
<span>Treatment</span>
<span id="selectedTreatment">Rp150.000</span>
</div>

<div class="summary-item">
<span>Service Fee</span>
<span>Rp10.000</span>
</div>

<div class="summary-item total">
<span>Total</span>
<span id="totalPrice">Rp160.000</span>
</div>

</aside>

</main>

<!-- ================= SCRIPT ================= -->
<script>


// ================= TREATMENT PRICE =================

const treatment = document.getElementById("treatment");
const selectedTreatment = document.getElementById("selectedTreatment");
const totalPrice = document.getElementById("totalPrice");

const serviceFee = 10000;

function updatePrice() {
    const selectedOption = treatment.options[treatment.selectedIndex];
    const price = parseInt(selectedOption.dataset.price, 10);

    selectedTreatment.innerText =
        "Rp " + price.toLocaleString("id-ID");

    totalPrice.innerText =
        "Rp " + (price + serviceFee).toLocaleString("id-ID");
}

treatment.addEventListener("change", updatePrice);

updatePrice();


// ================= ADDRESS TOGGLE =================

const addressBox = document.getElementById("addressBox");
const addressInput = document.querySelector('textarea[name="address"]');

document.querySelectorAll('input[name="place"]').forEach((radio) => {
    radio.addEventListener("change", () => {
        const isHome = radio.checked && radio.value === "home";

        addressBox.classList.toggle("hidden", !isHome);

        if (addressInput) {
            addressInput.required = isHome;

            if (!isHome) {
                addressInput.value = "";
            }
        }
    });
});


// ================= DATE VALIDATION =================

const tanggalBooking = document.getElementById("booking_date");
const jamBooking = document.querySelector('select[name="booking_time"]');

const timeMessage = document.getElementById("timeMessage");

function getLocalDate() {
    const now = new Date();

    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0");
    const day = String(now.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}

// Tanggal sebelum hari ini tidak dapat dipilih
function setTanggalMinimum() {
    tanggalBooking.min = getLocalDate();

    // Jika tanggal yang sudah dipilih menjadi tanggal lampau,
    // kosongkan pilihan tanggal dan jam.
    if (tanggalBooking.value && tanggalBooking.value < getLocalDate()) {
        tanggalBooking.value = "";
        jamBooking.value = "";
    }
}


// ================= TIME VALIDATION =================

function updateAvailableTimes() {
    const now = new Date();

    const hariIni = getLocalDate();
    const tanggalDipilih = tanggalBooking.value;

    const jamSekarang = now.getHours() * 60 + now.getMinutes();

    Array.from(jamBooking.options).forEach((option) => {
        if (option.value === "") return;

        const [hour, minute] = option.value.split(":").map(Number);

        const waktuBooking = hour * 60 + minute;

        const sudahLewat =
            tanggalDipilih === hariIni &&
            waktuBooking <= jamSekarang;

        option.disabled = sudahLewat;
    });

    // Jika jam yang terpilih sudah berlalu, kosongkan
    if (
        jamBooking.selectedOptions.length > 0 &&
        jamBooking.selectedOptions[0].disabled
    ) {
        jamBooking.value = "";
    }

    if (tanggalDipilih === hariIni) {
        timeMessage.textContent =
            "Jam yang sudah berlalu tidak dapat dipilih.";
    } else {
        timeMessage.textContent =
            "Silakan pilih jam treatment yang tersedia.";
    }

    
}


// Jalankan validasi ketika tanggal berubah
tanggalBooking.addEventListener("change", () => {
    jamBooking.value = "";
    updateAvailableTimes();
});

// Atur tanggal minimum ketika halaman dibuka
setTanggalMinimum();

// Periksa jam ketika halaman dibuka
updateAvailableTimes();

// Perbarui tanggal dan jam setiap menit
setInterval(() => {
    setTanggalMinimum();
    updateAvailableTimes();
}, 60000);


// ================= FORM SUBMIT VALIDATION =================

const bookingForm = document.getElementById("bookingForm");

bookingForm.addEventListener("submit", function (event) {
    const hariIni = getLocalDate();

    if (!tanggalBooking.value || tanggalBooking.value < hariIni) {
        event.preventDefault();
        alert("Tanggal booking tidak valid. Silakan pilih tanggal hari ini atau setelahnya.");
        return;
    }

    const now = new Date();

    if (tanggalBooking.value === hariIni) {
        const [hour, minute] = jamBooking.value.split(":").map(Number);

        const waktuBooking = hour * 60 + minute;
        const jamSekarang = now.getHours() * 60 + now.getMinutes();

        if (!jamBooking.value || waktuBooking <= jamSekarang) {
            event.preventDefault();
            alert("Jam booking sudah berlalu. Silakan pilih jam lain.");
            return;
        }
    }
});


</script>

</body>
</html>