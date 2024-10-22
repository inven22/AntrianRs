@extends('layouts.layout')

@section('title', 'Sistem Informasi Antrian')

@section('additional_css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    .background-slideshow {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -2;
    }

    .background-slideshow > div {
        position: absolute;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    .background-slideshow > div.active {
        opacity: 1;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        z-index: -1;
    }

    .header {
        background-color: rgba(40, 167, 69, 0.9);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 100;
    }

    .main-content {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 85px 3px;
    }

    .queue-row {
        display: flex;
        justify-content: center;
        gap: 20px; /* Adjust this value to control the space between containers */
    }

    .queue-container {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        padding: 30px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-width: 400px;
        width: 100%;
    }

    .queue-container:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }

    .queue-container h3 {
        color: #28a745;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.8rem;
    }

    .queue-number {
        font-size: 7rem;
        font-weight: bold;
        color: #28a745;
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    .btn-speak {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 20px;
    }

    .btn-speak:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .btn-speak:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.5);
    }

    .footer {
        background-color: rgba(52, 58, 64, 0.9);
        color: white;
        padding: 12px;
        text-align: center;
        box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
    }

    .footer h2 {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .social-icons i {
        font-size: 1.8rem;
        margin: 0 15px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .social-icons i:hover {
        color: #28a745;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @media (max-width: 768px) {
        .queue-row {
            flex-direction: column;
            align-items: center;
        }

        .queue-container {
            margin-bottom: 20px;
        }

        .queue-number {
            font-size: 5rem;
        }

        .btn-speak {
            padding: 12px 24px;
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="background-slideshow">
    <div style="background-image: url('https://th.bing.com/th/id/OIP.BpMMKdxR51_qW7cGdptBuQAAAA?w=230&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7')" class="active"></div>
    <div style="background-image: url('https://th.bing.com/th/id/OIP.jJVtuM654gWXVevISSWyrgHaEK?pid=ImgDet&w=173&h=97&c=7&dpr=1,5')"></div>
    <div style="background-image: url('https://th.bing.com/th/id/OIP.Ojzc4Uk3pbFOZeSL_6YnwQHaFj?w=218&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7')"></div>
</div>
<div class="overlay"></div>

<center><div class="main-content">
    <div class="container">
        <div class="queue-row">
            <div class="col-md-5">
                <div class="queue-container">
                    <h3>ANTRIAN PASIEN BPJS</h3>
                    <p class="mb-2">Nomor Antrian</p>
                    <p class="queue-number pulse" id="bpjs-queue">P06</p>
                    <p class="mt-3">POLI THT</p>
                    <button class="btn-speak" onclick="speakQueue('bpjs')">Panggil Antrian BPJS</button>
                </div>
            </div>
            <div class="col-md-5">
                <div class="queue-container">
                    <h3>ANTRIAN PASIEN UMUM</h3>
                    <p class="mb-2">Nomor Antrian</p>
                    <p class="queue-number pulse" id="umum-queue">U07</p>
                    <p class="mt-3">POLI MULUT</p>
                    <button class="btn-speak" onclick="speakQueue('umum')">Panggil Antrian Umum</button>
                </div>
            </div>
        </div>
    </div>
</div></center>

<div class="footer">
    <div class="container">
        <marquee><h2>KLINIK MEDIA MEDIKA</h2></marquee>
        <div class="social-icons mt-3">
            <i class="bi bi-facebook"></i>
            <i class="bi bi-twitter"></i>
            <i class="bi bi-instagram"></i>
        </div>
    </div>
</div>
@endsection

@section('additional_js')
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.background-slideshow > div');
    const totalSlides = slides.length;

    function showNextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % totalSlides;
        slides[currentSlide].classList.add('active');
    }

    // Auto-advance slides every 10 seconds
    setInterval(showNextSlide, 10000);

    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
    }

    function updateQueueNumbers() {
        fetch('/api/queue-numbers')
            .then(response => response.json())
            .then(data => {
                animateQueueChange('bpjs-queue', data.bpjs);
                animateQueueChange('umum-queue', data.umum);
            })
            .catch(error => console.error('Error:', error));
    }

    function animateQueueChange(elementId, newValue) {
        const element = document.getElementById(elementId);
        element.style.transform = 'scale(1.1)';
        element.style.transition = 'transform 0.3s ease';
        setTimeout(() => {
            element.textContent = newValue;
            element.style.transform = 'scale(1)';
        }, 300);
    }

    function speakQueue(type) {
        let queueNumber, poli;
        if (type === 'bpjs') {
            queueNumber = document.getElementById('bpjs-queue').textContent;
            poli = 'POLI THT';
        } else {
            queueNumber = document.getElementById('umum-queue').textContent;
            poli = 'POLI MULUT';
        }

        const message = `Nomor antrian ${queueNumber}, silahkan menuju ${poli}`;
        
        // Check if browser supports speech synthesis
        if ('speechSynthesis' in window) {
            const speech = new SpeechSynthesisUtterance(message);
            speech.lang = 'id-ID'; // Set language to Indonesian
            speech.rate = 0.9; // Slightly slower rate for clarity
            speech.pitch = 1;
            window.speechSynthesis.speak(speech);
        } else {
            alert('Maaf, browser Anda tidak mendukung fitur text-to-speech.');
        }
    }

    // Initialize
    updateDateTime();
    setInterval(updateDateTime, 60000);
    updateQueueNumbers();
    setInterval(updateQueueNumbers, 10000);
</script>
@endsection