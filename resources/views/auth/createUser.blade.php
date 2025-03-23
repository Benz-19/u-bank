<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-black flex items-center justify-center min-h-screen text-white flex-col">

    <!-- Success & Error Messages -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        <button type="submit" class="py-3 bg-blue-500 text-white font-semibold rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
            @php
                $url = (session('registration_role') === 'client') ? '/client-login' : '/admin-login'; //redirects the user to the appropriate login page
            @endphp
            <a href="{{$url}}">Login Here</a>
        </button>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Glassmorphic Registration Form -->
    <div class="glass p-8 max-w-sm w-full">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-semibold">Create Account</h2>
            <p class="text-lg text-gray-400">Join us today!</p>
        </div>

        <!-- Registration Form -->
        <form action="/register-user" method="POST">
            {{session('registration_role')}}
            {{dd(session('registration_role'))}}
            @csrf
            <input type="hidden" name="role" value="{{ session('registration_role') }}"/>
            <div class="mb-6">
                <input type="text" name="name" id="name" placeholder="Full Name"
                       class="w-full p-3 bg-transparent border-2 border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                       required />
            </div>

            <div class="mb-6">
                <input type="email" name="email" id="email" placeholder="Email Address"
                       class="w-full p-3 bg-transparent border-2 border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                       required />
            </div>

            <div class="mb-6">
                <input type="password" name="password" id="password" placeholder="Password"
                       class="w-full p-3 bg-transparent border-2 border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                       required />
            </div>

            <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                Sign Up
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="flex mt-20">
        @include('includes.footer')
    </div>
</body>
</html>
