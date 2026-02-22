<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-800 transition-colors duration-300">
        <div class="w-full max-w-5xl bg-white dark:bg-gray-900 rounded-2xl shadow-xl flex overflow-hidden transition-colors duration-300">

            <!-- القسم الأيسر -->
            <div class="w-1/2 bg-gradient-to-br from-blue-500 to-teal-400 flex flex-col items-center justify-center text-white p-10">
                <img src="{{ asset('logo.png') }}" class="w-40 mb-6">
                <h2 class="text-2xl font-bold mb-2">أصيل</h2>
                <p class="text-center text-sm leading-6">
                    اجعل تقاريرك المالية أكثر وضوحًا وسهولة<br>
                    مع نظام أصيل لإدارة الحسابات والمستندات
                </p>
            </div>

            <!-- القسم الأيمن -->
            <div class="w-1/2 p-10 text-black dark:text-gray-100 transition-colors duration-300">

                <h2 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-6">تسجيل الدخول</h2>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-700 border border-red-200 dark:border-red-800 p-4 text-red-700 dark:text-red-100 text-sm transition-colors duration-300">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="text-sm text-gray-600 dark:text-gray-300">البريد الإلكتروني</label>
                        <input type="email" name="email" required autofocus
                               class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                               dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 transition-colors duration-300">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm text-gray-600 dark:text-gray-300">كلمة المرور</label>
                        <input type="password" name="password" required
                               class="w-full mt-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                               dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 transition-colors duration-300">
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center text-sm dark:text-gray-300">
                            <input type="checkbox" name="remember" class="mr-2">
                            تذكرني
                        </label>

                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            نسيت كلمة المرور؟
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 dark:bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition-colors duration-300">
                        دخول
                    </button>

                    <p class="text-sm mt-4 dark:text-gray-300">
                        ليس لديك حساب؟
                        <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            إنشاء حساب جديد
                        </a>
                    </p>

                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
