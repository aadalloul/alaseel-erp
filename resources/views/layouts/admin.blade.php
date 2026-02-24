<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="darkMode()" :class="{ 'dark': isDark }" x-init="init()">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'لوحة التحكم')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1);
            transition: 0.3s;
        }

    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-black dark:text-gray-100 font-sans transition-colors duration-300">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- المحتوى --}}
    <div class="flex-1 flex flex-col">

        {{-- Top Navbar --}}
        @include('layouts.topbar')
        @if(session('success') || session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        toast: true,
                        position: 'top-start',
                        icon: '{{ session('success') ? 'success' : 'error' }}',
                        title: '{{ session('success') ?? session('error') }}',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.style.marginTop = '70px'; // تحت التوب بار
                        }
                    });
                });
            </script>
        @endif

        {{-- عنوان الصفحة + زر الهيدر --}}
        <div class="flex justify-between items-center mb-6 flex-wrap gap-4 px-6 pt-6">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-gray-200">
                @yield('title')
            </h1>

            <div>
                @yield('header-button')
            </div>
        </div>

        {{-- الصفحة --}}
        <main class="px-6 pb-6 flex-1">
            @yield('content')
        </main>

    </div>

</div>

<!-- سكربت Dark Mode -->

<script>
    function darkMode() {
        return {
            isDark: false,
            init() {
                this.isDark = localStorage.getItem('darkMode') === 'true';
                if(this.isDark) document.documentElement.classList.add('dark');
            },
            toggle() {
                this.isDark = !this.isDark;
                localStorage.setItem('darkMode', this.isDark);
                document.documentElement.classList.toggle('dark', this.isDark);
            }
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تستطيع التراجع عن هذا الإجراء!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم، احذفها!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
        .notification((notification) => {
            alert(notification.message); // مثال بسيط
            // أو عرضها في قائمة إشعارات داخل الصفحة
            let container = document.getElementById('notifications');
            let div = document.createElement('div');
            div.innerText = notification.user + ': ' + notification.message;
            container.prepend(div);
        });
</script>
<div id="notifications"></div>
@vite(['resources/js/app.js'])
</body>
</html>
