<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center">

        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl flex overflow-hidden">

            <!-- القسم الأيسر (الشعار) -->
            <div class="w-1/2 bg-gradient-to-br from-blue-500 to-teal-400
                        flex flex-col items-center justify-center text-white p-10">

                <img src="{{ asset('logo.png') }}" class="w-40 mb-6">

                <h2 class="text-2xl font-bold mb-2">أصيل</h2>

                <p class="text-center text-sm leading-6">
                    استمتع بوصول آمن ومُشفّر لبياناتك<br>
                    من أي مكان وفي أي وقت
                </p>
            </div>

            <!-- القسم الأيمن (الفورم) -->
            <div class="w-1/2 p-10">

                <h2 class="text-2xl font-bold text-blue-600 mb-6">
                    استعادة كلمة المرور
                </h2>

                <p class="text-sm text-gray-600 mb-6">
                    أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة تعيين كلمة المرور.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="text-sm text-gray-600">
                            البريد الإلكتروني
                        </label>

                        <input type="email" name="email" required autofocus
                               class="w-full mt-1 border rounded-lg px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg
                                   hover:bg-blue-700 transition">
                        إرسال رابط الاستعادة
                    </button>

                    <p class="text-sm mt-4">
                        تذكرت كلمة المرور؟
                        <a href="{{ route('login') }}"
                           class="text-blue-600 hover:underline">
                            تسجيل الدخول
                        </a>
                    </p>

                </form>

            </div>
        </div>
    </div>

</x-guest-layout>
