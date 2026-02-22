<aside class="w-64 bg-gradient-to-b from-blue-600 to-teal-500 dark:from-gray-900 dark:to-gray-800 text-white flex flex-col transition-colors duration-300">

    <!-- اللوجو -->
    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/20 dark:border-gray-700">
        <img src="{{ asset('logo.png') }}" class="w-10 h-10">
        <div>
            <h1 class="font-bold text-lg">أصيل</h1>
            <p class="text-xs opacity-80">لوحة التحكم</p>
        </div>
    </div>

    <!-- المستخدم -->
    <div class="px-6 py-4 flex items-center gap-3 border-b border-white/20 dark:border-gray-700">
        <img
            src="{{ auth()->user()->profile_image ? asset('storage/'.auth()->user()->profile_image) : asset('default-avatar.png') }}"
            class="w-10 h-10 rounded-full border border-white dark:border-gray-300">
        <div>
            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-xs opacity-80">
                @if(auth()->user()->is_admin)
                    مدير النظام
                @else
                    مستخدم
                @endif
            </p>
        </div>
    </div>

    <!-- القائمة -->
    <nav class="flex-1 px-4 py-6 space-y-2">

        <!-- لوحة التحكم -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
            <i class="fa fa-chart-line"></i>
            <span>لوحة التحكم</span>
        </a>

    @if(auth()->user()->is_admin)
        <!-- الروابط كاملة للادمن -->
            <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-users"></i>
                <span>العملاء</span>
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-box"></i>
                <span>المنتجات</span>
            </a>
            <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-cart-plus"></i>
                <span>المشتريات</span>
            </a>
            <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-file-invoice"></i>
                <span>الفواتير</span>
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-chart-pie"></i>
                <span>التقارير</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-gear"></i>
                <span>الإعدادات</span>
            </a>
            <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-user-shield"></i>
                <span>الأدوار والصلاحيات</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                <i class="fa fa-users-cog"></i>
                <span>المستخدمون</span>
            </a>
    @else
        <!-- المستخدم العادي حسب الصلاحيات -->
            @can('customers.view')
                <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-users"></i>
                    <span>العملاء</span>
                </a>
            @endcan
            @can('products.view')
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-box"></i>
                    <span>المنتجات</span>
                </a>
            @endcan
            @can('purchases.view')
                <a href="{{ route('purchases.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-cart-plus"></i>
                    <span>المشتريات</span>
                </a>
            @endcan
            @can('invoices.view')
                <a href="{{ route('invoices.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-file-invoice"></i>
                    <span>الفواتير</span>
                </a>
            @endcan
            @can('reports.view')
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-chart-pie"></i>
                    <span>التقارير</span>
                </a>
            @endcan
            @can('settings.edit')
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
                    <i class="fa fa-gear"></i>
                    <span>الإعدادات</span>
                </a>
        @endcan
    @endif

    <!-- الملف الشخصي -->
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-white/20 dark:hover:bg-gray-600 transition">
            <i class="fa fa-user"></i>
            <span>الملف الشخصي</span>
        </a>
    </nav>

    <!-- تسجيل الخروج -->
    <div class="px-4 py-4 border-t border-white/20 dark:border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-red-500/80 transition">
                <i class="fa fa-sign-out-alt"></i>
                تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
