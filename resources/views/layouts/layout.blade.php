<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="refresh" content="10"> --}}
    <title>@yield('title', 'Informasi Antrian Rumah Sakit')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        /* .navbar {
            background-color: #007bff;
        } */
        /* .navbar-brand {
            color: white !important;
            font-weight: bold;
        } */
        .footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
            margin-top: 2rem;
        }
        /* .navbar .container{
            padding-left: 100px; 
        } */
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: linear-gradient(45deg, #3b82f6, #60a5fa, #93c5fd);
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            animation: pulse 2s infinite;
        }
        .clinic-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .time-container {
            display: flex;
            align-items: center;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .time-container:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        .clock-icon {
            width: 24px;
            height: 24px;
            margin-right: 0.5rem;
            animation: pulse 2s infinite;
        }
        #current-time {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
    @yield('additional_css')
</head>
<body>
    <header class="header">
        <div class="logo-container">
            <img src="/api/placeholder/50/50" alt="Logo Klinik Media Medika" class="logo">
            <h1 class="clinic-name">Klinik Media Medika</h1>
        </div>
        <div class="time-container">
            <svg class="clock-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="current-time"></span>
        </div>
    </header>
    
    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="footer text-center">
        <div class="container">
            <span>&copy; 2024 Klinik Media Medika. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    <script>
        function updateTime() {
            const timeElement = document.getElementById('current-time');
            const now = new Date();
            timeElement.textContent = now.toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta' });
        }

        setInterval(updateTime, 1000);
        updateTime(); // Initial call to display time immediately
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('additional_js')
</body>
</html>