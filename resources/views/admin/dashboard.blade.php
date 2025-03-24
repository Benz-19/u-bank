
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
  <div class="flex h-screen">
      <!-- Sidebar -->
      <aside class="w-64 bg-gray-800 p-5 space-y-6">
          <h1 class="text-xl font-bold">U-Bank Admin</h1>
          <div class="flex flex-col mb-6">
          <p class="font-bold">Admin: {{$adminName}}</p>
          <p class="font-bold">Id: {{$adminId}}</p>
        </div>
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
          <div id="users" class="panel">
              <h2 class="text-2xl font-bold">Manage Users</h2>
              <div class="flex justify-between mb-4">
                <button onclick="addUser()" class="mt-4 bg-blue-500 px-4 py-2 rounded">Add User</button>
                <a href="/logout">
                  <button class="mt-4 bg-red-500 px-4 py-2 rounded">logout</button>
                </a>
              </div>
              <table class="min-w-full border border-gray-700 text-white">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="p-3 text-left border border-gray-700">Name</th>
                        <th class="p-3 text-left border border-gray-700">Email</th>
                        <th class="p-3 text-center border border-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($getAllClients as $client)
                    <tr class="border border-gray-700">
                        <td class="p-3 border border-gray-700">{{ $client->name }}</td>
                        <td class="p-3 border border-gray-700">{{ $client->email }}</td>
                        <td class="p-3 text-center border border-gray-700">
                            <a href="{{url('/clientTransaction', $client->id)}}">
                                <button class="bg-green-500 hover:bg-gray-600 text-white px-3 py-1 rounded ml-2">View Transactions</button>
                            </a>
                            <a href="{{url('/editClient', $client->id)}}">
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1 rounded">Edit Client</button>                                
                            </a>
                            <a href="{{url('/deleteClient', $client->id)}}">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded ml-2">Delete</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
          </div>
      </main>
  </div>

</body>
</html>
