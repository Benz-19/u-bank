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
   
    <title>UserTransaction</title>
</head>
<body class="bg-gray-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 p-5 space-y-6">
            <h1 class="text-xl font-bold">U-Bank Admin</h1>
            <div class="flex flex-col mb-6">
            <p class="font-bold">Admin: {{$adminName}}</p>
            <p class="font-bold">Id: {{$adminId}}</p>
          </div>
            <nav class="space-y-4">
                <button onclick="showPanel('users')" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 w-full">
                    Users
                </button>
                <button onclick="showPanel('transactions')" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 w-full">
                    Transactions
                </button>
                <button onclick="showPanel('settings')" class="flex items-center gap-3 p-2 rounded hover:bg-gray-700 w-full">
                    Settings
                </button>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Users Panel -->
            <div id="users" class="panel">
                <h2 class="text-2xl font-bold">Manage Users</h2>
                <div class="flex justify-between mb-4">
                    <a href="/admin/dashboard">
                        <button class="mt-4 bg-blue-500 px-4 py-2 rounded">Dashboard</button>
                    </a>
                  <a href="/logout">
                    <button class="mt-4 bg-red-500 px-4 py-2 rounded">logout</button>
                  </a>
                </div>
                <table class="min-w-full border border-gray-700 text-white">
                  <thead class="bg-gray-800">
                      <tr>
                          <th class="p-3 text-left border border-gray-700">Name</th>
                          <th class="p-3 text-left border border-gray-700">Account No</th>
                          <th class="p-3 text-center border border-gray-700">Current Bal</th>
                          <th class="p-3 text-center border border-gray-700">Trans Amount</th>
                          <th class="p-3 text-center border border-gray-700">Recipient Acc</th>
                          <th class="p-3 text-center border border-gray-700">Description</th>
                          <th class="p-3 text-center border border-gray-700">Date</th>
                      </tr>
                  </thead>
                  <tbody>
                    @if (count($clientTransaction) === 0)
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-400">
                            No record to display
                        </td>
                    </tr>
                    @else
                      @foreach ($clientTransaction as $client)
                      <tr class="border border-gray-700">
                          <td class="p-3 border border-gray-700">{{ $clientName }}</td>
                          <td class="p-3 border border-gray-700">{{ $clientAccNo }}</td>
                          <td class="p-3 border border-gray-700">{{ $client->current_balance }}</td>
                          <td class="p-3 border border-gray-700">{{ $client->amount }}</td>
                          <td class="p-3 border border-gray-700">{{ $client->recipientAcc_no }}</td>
                          <td class="p-3 border border-gray-700">{{ $client->description }}</td>
                          <td class="p-3 border border-gray-700">{{ $client->created_at }}</td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
              </table>
              
            </div>
            
            <!-- Transactions Panel -->
            <div id="transactions" class="panel hidden">
                <h2 class="text-2xl font-bold">Transactions</h2>
            </div>
            
            <!-- Settings Panel -->
            <div id="settings" class="panel hidden">
                <h2 class="text-2xl font-bold">Settings</h2>
            </div>
        </main>
    </div>
  
    
</body>
</html>