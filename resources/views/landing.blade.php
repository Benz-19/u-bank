<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero-section {
            position: relative;
            background: url("{{ asset('images/hero.jpg') }}") no-repeat center center;
            background-size: cover;
            max-width: 100%;
            min-height: 100vh;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); 
            overflow: hidden;
            text-overflow: inherit;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    @include('includes.header')


    <!-- Hero Section -->
    <section class="hero-section relative flex items-center justify-center h-screen bg-cover bg-center">
        <div class="hero-overlay"></div>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center text-white px-6 md:px-12">
            <h1 class="text-4xl font-bold md:text-6xl">Welcome to Our Platform</h1>
            <p class="mt-4 text-lg md:text-xl">Your journey to excellence starts here.</p>
            <a href="/client-login" class="mt-6 inline-block bg-indigo-600 px-6 py-3 text-lg font-semibold text-white rounded-md shadow-md hover:bg-indigo-700">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800">Our Features</h2>
            <p class="mt-4 text-lg text-gray-600">Discover what makes us unique.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto mt-12 px-6">
            <div class="p-6 bg-gray-200 rounded-lg shadow">
                <h3 class="text-xl font-semibold text-gray-800">Feature 1</h3>
                <p class="mt-2 text-gray-600">Description of Feature 1.</p>
            </div>
            <div class="p-6 bg-gray-200 rounded-lg shadow">
                <h3 class="text-xl font-semibold text-gray-800">Feature 2</h3>
                <p class="mt-2 text-gray-600">Description of Feature 2.</p>
            </div>
            <div class="p-6 bg-gray-200 rounded-lg shadow">
                <h3 class="text-xl font-semibold text-gray-800">Feature 3</h3>
                <p class="mt-2 text-gray-600">Description of Feature 3.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('includes.footer')

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            alert('Mobile menu clicked (Implement dropdown menu logic here)');
        });
    </script>
</body>
</html>
