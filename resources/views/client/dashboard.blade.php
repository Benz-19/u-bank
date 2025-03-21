<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Bank Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-blue-900 text-white p-5 space-y-6">
            <h1 class="text-2xl font-bold">U-Bank</h1>
            <nav class="space-y-4">
                <a href="#" class="block p-2 rounded hover:bg-blue-700">Dashboard</a>
                {{-- <a href="#" class="block p-2 rounded hover:bg-blue-700">Transactions</a> --}}
                <a href="/deposit" class="block p-2 rounded hover:bg-blue-700">Deposit</a>
                <a href="/withdrawal" class="block p-2 rounded hover:bg-blue-700">Withdraw</a>
                <a href="/transfer" class="block p-2 rounded hover:bg-blue-700">Transfer</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-700">Accounts</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-700">Settings</a>
                <form action="/generateAccountNumber" method="post">
                    @csrf
                    <button class="py-3 bg-blue-500 text-white font-semibold rounded-md shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">generate Account Number</button>
                </form>
            </nav>
            <div style="margin-top:auto;">
                @php
                    $year = date('Y');
                    echo "<p> &copy; $year u-bank-team. All rights reserved.</p>";
                @endphp
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold">Dashboard</h2>
                <a href="/logout">
                  <button class="bg-blue-600 text-white px-4 py-2 rounded">Logout</button>
                </a>
            </div>

            <div class="flex flex-col">
                <p class="font-bold">Welcome {{$userName}}</p>
                <p>Acc no: {{ $accountNumber}}</p>
            </div>
            
            <!-- Account Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Available Balance</h3>
                    <p class="text-2xl font-bold">${{$currentBalance}}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Savings</h3>
                    <p class="text-2xl font-bold">$5,300.00</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-gray-600">Expenses</h3>
                    <p class="text-2xl font-bold">$1,250.00</p>
                </div>
            </div>
            
            <!-- Transactions Table -->
            <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4">All Transactions</h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2 text-left">Date</th>
                            <th class="p-2 text-left">Description</th>
                            <th class="p-2 text-left">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $index = 0; @endphp
                        @foreach ($userTransactions as $userTransaction)
                        <tr class="border-b">
                            <td class="p-2">{{$transactionDate[$index]}}</td>
                            <td class="p-2">{{$userTransaction->description}}</td>
                       
                            @if ($userTransaction->type === 'deposit')
                            <td class="p-2 text-green-600">+ {{$userTransaction->amount}}</td>                               
                           @else
                           <td class="p-2 text-red-600">- {{$userTransaction->amount}}</td>                               
                           @endif
                        </tr>
                        @php $index++; @endphp
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
