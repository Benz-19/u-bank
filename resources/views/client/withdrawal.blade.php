<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'u-bank-blue': '#2563eb', //  blue 
                        'u-bank-gray': '#6b7280', //  gray 
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">

    @if (session('success'))
    <div class="flex flex-col items-center justify-center py-5 px-4 sm:px-6 lg:px-8">
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        <button type="submit" class="w-fit py-3 bg-red-500 text-white font-semibold rounded-md shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
            @php
                $url = '/client/dashboard'; //redirects the user to the appropriate login page
            @endphp
            <a href="{{$url}}">Return</a>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Make a new Withdrawal
            </h2>
        </div>
        <form class="mt-8 space-y-6" action="#" method="POST">
        @csrf
            <input type="hidden" name="remember" value="true">
            <div class="rounded-md shadow-sm -space-y-px">
                <div class="flex ">
                    <label for="amount" class="mr-2">Amount</label>
                    <input id="amount" name="withdrawAmount" type="number" class="mb-2 appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-u-bank-blue focus:border-u-bank-blue focus:z-10 sm:text-sm" placeholder="Enter an amount...">
                </div>
                {{-- <div class="flex mt-2">
                    <label for="description" class="mr-2">Description</label>
                    <input id="description" name="description" type="text" autocomplete="off" class="appearance-none rounded-none relative block w-full h-12 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-u-bank-blue focus:border-u-bank-blue focus:z-10 sm:text-sm align-text-start" placeholder="Description">
                </div> --}}
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-700 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-u-bank-blue">
                    withdraw
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>