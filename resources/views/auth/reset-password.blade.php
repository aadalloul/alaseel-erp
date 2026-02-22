<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center">

        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl flex overflow-hidden">

            <!-- القسم الأيسر (الشعار) -->
            <div class="w-1/2 bg-gradient-to-br from-blue-500 to-teal-400
                        flex flex-col items-center justify-center text-white p-10">

                <img src="{{ asset('logo.png') }}" class="w-40 mb-6">

                <h2 class="text-2xl font-bold mb-2">أصيل</h2>

                <p class="text-center text-sm leading-6">
                    قم بتعيين كلمة مرور قوية<br>
                    للحفاظ على أمان حسابك
                </p>
            </div>

            <!-- القسم الأيمن (الفورم) -->
            <div class="w-1/2 p-10">

                <h2 class="text-2xl font-bold text-blue-600 mb-6">
                    إعادة تعيين كلمة المرور
                </h2>

                <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-4">
                        <label class="text-sm text-gray-600">البريد الإلكتروني</label>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                               class="w-full mt-1 border rounded-lg px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label class="text-sm text-gray-600">كلمة المرور الجديدة</label>
                        <input type="password" name="password" required
                               class="w-full mt-1 border rounded-lg px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-6">
                        <label class="text-sm text-gray-600">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full mt-1 border rounded-lg px-3 py-2
                               focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg
                                   hover:bg-blue-700 transition">
                        حفظ كلمة المرور
                    </button>

                </form>

            </div>
        </div>
    </div>

</x-guest-layout>
