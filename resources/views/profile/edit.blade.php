@extends('layouts.admin')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="max-w-5xl mx-auto p-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex gap-8 bg-white p-8 rounded-3xl shadow-lg">
        @csrf
        @method('PATCH')

        <!-- قسم الصورة -->
            <div class="flex flex-col items-center gap-4">
                <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('default-avatar.png') }}"
                     class="w-36 h-36 rounded-full border-4 border-blue-500 object-cover">

                <label class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    اختر صورة
                    <input type="file" name="profile_image" class="hidden">
                </label>
            </div>

            <!-- قسم البيانات -->
            <div class="flex-1 flex flex-col gap-4">
                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="الاسم الكامل"
                       class="w-full border px-4 py-3 rounded">

                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="البريد الإلكتروني"
                       class="w-full border px-4 py-3 rounded">

                <input type="password" name="password" placeholder="كلمة المرور (اختياري)" class="w-full border px-4 py-3 rounded">

                <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" class="w-full border px-4 py-3 rounded">

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
@endsection
