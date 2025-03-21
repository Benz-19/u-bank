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
                <a href="#" class="block p-2 rounded hover:bg-blue-700">Transactions</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-700">Accounts</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-700">Settings</a>
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
                        <tr class="border-b">
                            <td class="p-2">March 19, 2025</td>
                            <td class="p-2">Grocery Shopping</td>
                            <td class="p-2 text-red-600">- $120.00</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">{{$transactionDate[0]}}</td>
                            <td class="p-2">{{$userTransactions[0]->description}}</td>
                            <td class="p-2 text-green-600">+ ${{$userTransactions[0]->amount}}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-2">March 18, 2025</td>
                            <td class="p-2">Salary Deposit</td>
                            <td class="p-2 text-green-600">+ $2,500.00</td>
                        </tr>
                        <tr>
                            <td class="p-2">March 17, 2025</td>
                            <td class="p-2">Utility Bill</td>
                            <td class="p-2 text-red-600">- $200.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
