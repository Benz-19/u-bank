<header class="absolute inset-x-0 top-0 z-50 h-28 bg-gray-500 bg-opacity-25">
  <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
      <div class="flex lg:flex-1">
          <a href="#" class="-m-1.5 p-1.5">
              <img class="w-32 h-16" src="{{ asset('images/logo.png') }}" alt="Logo">
          </a>
      </div>
      <div class="flex lg:hidden">
          <button type="button" id="menu-toggle" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
              <span class="sr-only">Open main menu</span>
              <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
          </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
          <a href="#" class="text-lg font-semibold text-gray-900">Product</a>
          <a href="#" class="text-lg font-semibold text-gray-900">Features</a>
          <a href="#" class="text-lg font-semibold text-gray-900">Marketplace</a>
          <a href="#" class="text-lg font-semibold text-gray-900">Company</a>
      </div>
      <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <a href="/client-login" class="inline-flex items-center rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-md">Get Started &rarr;</a>
      </div>
  </nav>
</header>