<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- styles --}}
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    @if (app()->environment('local'))
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endif

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.js') }}" rel="stylesheet">
    {{-- swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <style>
        .hero-section {
            position: relative;
            background: url("{{ asset('images/hero.png') }}") no-repeat center center;
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
        .login-btn,.learn-more-btn {
            transition: all 0.3s ease-in-out;
        }
        .login-btn:hover,.learn-more-btn:hover {
            transform: translateX(5px);
        }
        /* Swiper Slide Visibility */
        .swiper-slide {
            visibility: hidden; 
            opacity: 0;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
        .swiper-slide.swiper-slide-active {
            visibility: visible; 
            opacity: 1;
        }
        
        .swiper-container {
            overflow: hidden; 
        }

        .swiper-wrapper {
            display: flex; 
        }
    </style>
    <title>u-bank</title>
</head>
<body>
    <div class="bg-white">
        {{-- header --}}
        @include('includes.header')

        <div class="relative hero-section flex items-center justify-center text-white flex-wrap">
            <div class="hero-overlay"></div>
            <div class="swiper-container relative w-full max-w-4xl text-center z-10 flex flex-col">
                <div class="swiper-wrapper">
                    <div class="swiper-slide text-3xl font-bold">Empower your journey with data.</div>
                    <div class="swiper-slide text-3xl font-bold">Unlock new possibilities in business.</div>
                    <div class="swiper-slide text-3xl font-bold">Transform your ideas into reality.</div>
                    <div class="swiper-slide text-3xl font-bold">Make data-driven decisions today.</div>
                </div>
                <!-- Navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="">
                    <a href="/client-login" class="mt-6 inline-flex items-center rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-md login-btn">
                        Get Started <span class="ml-2">&rarr;</span>
                    </a>
                </div>
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <div class="relative isolate px-6 pt-14 lg:px-8">
          <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
          </div>
          <div class="mx-auto max-w-2xl py-18 sm:py-32 lg:py-20">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
              <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                Announcing our next round of funding. <a href="#" class="font-semibold text-indigo-600"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
              </div>
            </div>
            <div class="text-center">
              <h1 class="text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">Most Reliable online Banking Platform</h1>
              <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.</p>
              <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="/client-login" class="mt-6 inline-flex items-center rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-md login-btn">Get started</a>
                <a href="#" class="mt-6 inline-flex items-center rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-md learn-more-btn">Learn more <span aria-hidden="true">&rarr;</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- footer --}}
       @include('includes.footer')
      
<script>
document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper('.swiper-container', {
        loop: true, // Infinite loop
        autoplay: {
            delay: 9000, // Change slide every 4 seconds
            disableOnInteraction: false // Keep autoplay after user interaction
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });
});
</script>

</body>
</html>
