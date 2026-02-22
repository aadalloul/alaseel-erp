<nav class="bg-gradient-to-r from-blue-600 to-teal-500 dark:from-gray-900 dark:to-gray-800 px-6 py-3 flex items-center justify-between shadow transition-colors duration-300">

    <!-- العنوان -->
    <div class="text-white font-bold text-lg">
        لوحة التحكم
    </div>

    <!-- الجهة اليمنى: زر Dark Mode + المستخدم -->
    <div class="flex items-center gap-4">

        <!-- زر الوضع الليلي -->
        <button @click="toggle()" class="p-2 rounded-full bg-white/20 dark:bg-gray-700 text-white hover:bg-white/30 dark:hover:bg-gray-600 transition">
            <i x-show="!isDark" class="fa fa-moon"></i>
            <i x-show="isDark" class="fa fa-sun"></i>
        </button>

        <!-- المستخدم -->
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open"
                    class="flex items-center gap-3 focus:outline-none">

                <span class="text-white text-sm hidden sm:block">
                    {{ auth()->user()->name }}
                </span>

                <img
                    src="{{ auth()->user()->profile_image
                        ? asset('storage/'.auth()->user()->profile_image)
                        : asset('default-avatar.png') }}"
                    class="w-9 h-9 rounded-full border-2 border-white object-cover">
            </button>

            <!-- القائمة المنسدلة -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition
                 class="absolute left-0 mt-3 w-44 bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden z-50 transition-colors duration-300">

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-user"></i>
                    الملف الشخصي
                </a>

                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-700 transition">
                        <i class="fa fa-sign-out-alt"></i>
                        تسجيل الخروج
                    </button>
                </form>

            </div>
        </div>

    </div>

</nav>
