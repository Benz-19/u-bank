<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 15px;
            backdrop-filter: blur(10px); 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .con{
            color: red;
        }
    </style>
</head>
<body class="bg-black flex items-center justify-center min-h-screen text-white flex-col">
    
    @if (session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    @php
      if(session('user_id') === NULL)
        redirect('/')
    @endphp

    <!-- Glassmorphic Login Card -->
    <div class="glass p-8 max-w-sm w-full">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-semibold">Login</h2>
            <p class="text-lg text-gray-400">Welcome back! Please login to your account.</p>
        </div>

        <!-- Login Form -->
        <form action="/login-user" method="POST">
           {{session('userRole')}}
            @csrf
            <input type="hidden" name="role" value="{{$userRole}}"/>
            <div class="mb-6">
                <input
                    type="email"
                    name="email"
                    id="email"
                    placeholder="Email Address"
                    class="w-full p-3 bg-transparent border-2 border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                    required
                />
            </div>

            <div class="mb-6">
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    class="w-full p-3 bg-transparent border-2 border-gray-700 rounded-md text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"
                    required
                />
            </div>

            <div class="flex justify-between items-center mb-6">
               <div></div>
                <a href="#" class="text-sm text-blue-400 hover:underline">Forgot Password?</a>
            </div>

            <button
                type="submit"
                class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
            >
                Login
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">Don't have an account? <a href="/create-user" class="text-blue-400 hover:underline">Create an Account</a></p>
        </div>
    </div>
    
<!-- Footer -->
<div class="flex mt-20">
   @include('includes.footer')
</div>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>
</html>
