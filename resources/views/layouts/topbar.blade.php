<nav class="bg-gradient-to-r from-blue-600 to-teal-500 dark:from-gray-900 dark:to-gray-800 px-6 py-3 flex items-center justify-between shadow transition-colors duration-300">

    <!-- العنوان -->
    <div class="text-white font-bold text-lg">
        لوحة التحكم
    </div>

    <!-- الجهة اليمنى: Dark Mode + Notifications + المستخدم -->
    <div class="flex items-center gap-4">

        <!-- زر الوضع الليلي -->
        <button @click="toggle()" class="p-2 rounded-full bg-white/20 dark:bg-gray-700 text-white hover:bg-white/30 dark:hover:bg-gray-600 transition">
            <i x-show="!isDark" class="fa fa-moon"></i>
            <i x-show="isDark" class="fa fa-sun"></i>
        </button>

        <!-- رمز الإشعارات -->
        @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="relative text-white focus:outline-none">
                    <i class="fa fa-bell text-xl"></i>
                    <span id="notification-count" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs px-1.5 py-0.5">0</span>
                </button>

                <!-- قائمة الإشعارات -->
                <div x-show="open"
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden z-50 max-h-80 overflow-y-auto">

                    <div id="notifications-list" class="divide-y divide-gray-200 dark:divide-gray-600">
                        <!-- إشعارات جديدة ستضاف هنا ديناميكيًا -->
                    </div>
                </div>
            </div>
    @endauth

    <!-- المستخدم -->
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">

                <span class="text-white text-sm hidden sm:block">
                    {{ auth()->user()->name }}
                </span>

                <img
                    src="{{ auth()->user()->profile_image
                        ? asset('storage/'.auth()->user()->profile_image)
                        : asset('default-avatar.png') }}"
                    class="w-9 h-9 rounded-full border-2 border-white object-cover">
            </button>

            <!-- القائمة المنسدلة للمستخدم -->
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

<!-- سكربت إشعارات Laravel Echo -->
@auth
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if(typeof window.Echo !== 'undefined') {
                window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
                    .notification((notification) => {
                        // إضافة الإشعار للقائمة
                        let container = document.getElementById('notifications-list');
                        let div = document.createElement('div');
                        div.innerText = notification.user + ': ' + notification.message;
                        div.classList.add(
                            'px-4','py-2','text-sm','text-gray-700','dark:text-gray-200',
                            'hover:bg-gray-100','dark:hover:bg-gray-600'
                        );
                        container.prepend(div);

                        // تحديث عدد الإشعارات
                        let count = document.getElementById('notification-count');
                        count.innerText = parseInt(count.innerText) + 1;

                        // اختفاء الإشعار بعد 10 ثواني من القائمة
                        setTimeout(() => {
                            div.remove();
                            count.innerText = parseInt(count.innerText) - 1;
                        }, 10000);
                    });
            }
        });
    </script>
@endauth
