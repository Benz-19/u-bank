<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    @if (app()->environment('local'))
    <!-- component -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <title>Dashboard</title>
</head>
<body class="bg-gray-900 text-white">


    @if (session('success'))
    <div class="flex flex-col items-center justify-center py-5 px-4 sm:px-6 lg:px-8">
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        <button type="submit" class="w-fit py-3 bg-red-500 text-white font-semibold rounded-md shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
            @php
                $url = '/admin/dashboard'; //redirects the user to the appropriate login page
            @endphp
            <a href="{{$url}}">Return to Dashboard</a>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

  <div class="flex h-screen">
      <!-- Sidebar -->
      <aside class="w-64 bg-gray-800 p-5 space-y-6">
          <h1 class="text-xl font-bold">U-Bank Admin</h1>

          <nav class="space-y-4">
                <a href="/admin/dashboard">
                    <button class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 w-full">
                        Users
                    </button>
                </a>
                <a href="/admin/dashboard">
                    <button class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 w-full">
                        Transactions
                    </button>
                </a>
                <a href="/admin/dashboard">
                    <button class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 w-full">
                        Settings
                    </button>
                </a>
          </nav>
      </aside>
      
      <!-- Main Content -->
      <main class="flex-1 p-6">
          <!-- Users Panel -->
          <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Edit the Client Info
                    </h2>
                </div>
                <form class="mt-8 space-y-6 text-black" action="{{url('/editClient', $id)}}" method="POST">
                @csrf
                    <input type="hidden" name="remember" value="true">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div class="flex ">
                            <label for="name" class="mr-2">Amount</label>
                            <input id="name" value="{{$name}}" name="name" type="text" class="mb-2 appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-600 placeholder-black-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-u-bank-blue focus:border-u-bank-blue focus:z-10 sm:text-sm" placeholder="Client Name...">
                        </div>
                        <div class="flex mt-2">
                            <label for="email" class="mt-5 mr-5">Email</label>
                            <input id="email" value="{{$email}}" name="email" type="email" autocomplete="off" class="mt-5 appearance-none rounded-none relative block w-full h-12 border border-gray-600 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-u-bank-blue focus:border-u-bank-blue focus:z-10 sm:text-sm align-text-start" placeholder="Client Email...">
                        </div>
                        <div class="flex mt-2">
                            <label for="accountNo" class="mt-6 mr-2">account No: </label>
                            <input id="accountNo" value="{{$accountNo}}" name="accountNo" type="number" autocomplete="off" class="mt-5 appearance-none rounded-none relative block w-full h-12 border border-gray-600 placeholder-black-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-u-bank-blue focus:border-u-bank-blue focus:z-10 sm:text-sm align-text-start" placeholder="New Account Number">
                        </div>
                    </div>
        
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-u-bank-blue">
                            Update User Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
  </div>

</body>
</html>
