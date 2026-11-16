document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.getElementById("hamburger");
    const navbar = document.getElementById("navbar");

    if (hamburger && navbar) {
        hamburger.addEventListener("click", () => {
            // Toggle class 'active' pada navbar
            navbar.classList.toggle("active");
            
            // Opsional: Animasi icon hamburger menjadi 'X'
            if (navbar.classList.contains("active")) {
                hamburger.innerHTML = "✕"; // Ganti icon jadi silang
            } else {
                hamburger.innerHTML = "☰"; // Kembali ke menu bar
            }
        });
    }
});

// Aktifkan observer untuk animasi Flow In/Out
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
      } else {
        entry.target.classList.remove('active');
      }
    });
  }, { threshold: 0.1 });
  
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  
  // Logika untuk Dot Pagination
  const grid = document.getElementById('reviewGrid');
  const dots = document.querySelectorAll('.dot');
  
  grid.addEventListener('scroll', () => {
    const scrollIndex = Math.round(grid.scrollLeft / (grid.clientWidth / 1.5));
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === Math.min(scrollIndex, dots.length - 1));
    });
  });
  
  // jam
  document.addEventListener("DOMContentLoaded", () => {
    // Ambil elemen angka
    const minutesElement = document.getElementById("minutes");
    const secondsElement = document.getElementById("seconds");

    // Ambil nilai awal dari HTML dan ubah jadi angka
    let minutes = parseInt(minutesElement.innerText);
    let seconds = parseInt(secondsElement.innerText);

    // Jalankan fungsi setiap 1 detik (1000ms)
    const countdownInterval = setInterval(() => {
        if (seconds > 0) {
            // Kurangi detik
            seconds--;
        } else {
            // Jika detik habis (00), cek menit
            if (minutes > 0) {
                minutes--;
                seconds = 59; // Reset detik ke 59
            } else {
                // Jika menit dan detik sudah 0 semua
                clearInterval(countdownInterval);
                alert("Promo Berakhir!");
            }
        }

        // Tampilkan kembali ke HTML dengan format 2 digit (misal: 09, 08)
        minutesElement.innerText = minutes < 10 ? "0" + minutes : minutes;
        secondsElement.innerText = seconds < 10 ? "0" + seconds : seconds;

    }, 1000);
});


// Fungsi untuk membuka pop-up modal
function openModal(treatmentId) {
    const modal = document.getElementById('modal-' + treatmentId);
    if (modal) {
        modal.classList.remove('hidden'); // Menghilangkan class 'hidden' dari Tailwind
        document.body.style.overflow = 'hidden'; // Mengunci scroll halaman utama saat pop-up aktif
    }
}

// Fungsi untuk menutup pop-up modal
function closeModal(treatmentId) {
    const modal = document.getElementById('modal-' + treatmentId);
    if (modal) {
        modal.classList.add('hidden'); // Menambahkan kembali class 'hidden'
        document.body.style.overflow = ''; // Mengaktifkan kembali scroll halaman utama
    }
}

// Fungsi tambahan: Menutup pop-up jika user mengklik area luar kotak (area gelap/backdrop)
window.onclick = function(event) {
    if (event.target.id && event.target.id.startsWith('modal-')) {
        event.target.classList.add('hidden');
        document.body.style.overflow = '';
    }
}




const notifBtn = document.getElementById("notifBtn");
const notifPanel = document.getElementById("notifPanel");
const closeNotif = document.getElementById("closeNotif");

// open
notifBtn.addEventListener("click", () => {
    notifPanel.classList.add("active");
});

// close button
closeNotif.addEventListener("click", () => {
    notifPanel.classList.remove("active");
});

// klik luar untuk close
document.addEventListener("click", function(e){
    if(
        !notifPanel.contains(e.target) &&
        e.target !== notifBtn
    ){
        notifPanel.classList.remove("active");
    }
});

/* pilihan menu icon saat mode hp */

function toggleFab(){

    document
        .querySelector('.fab-container')
        .classList
        .toggle('active');

}

/* pilihan menu icon saat mode hp */



    const tanggalBooking = document.getElementById('booking_date');

    const hariIni = new Date();
    const tahun = hariIni.getFullYear();
    const bulan = String(hariIni.getMonth() + 1).padStart(2, '0');
    const tanggal = String(hariIni.getDate()).padStart(2, '0');

    tanggalBooking.min = `${tahun}-${bulan}-${tanggal}`;
