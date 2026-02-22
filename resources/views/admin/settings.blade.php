@extends('layouts.admin')

@section('title', 'الإعدادات')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 rounded-2xl shadow-lg p-6">
            <h3 class="text-gray-700 font-bold mb-4">إعدادات عامة</h3>
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-600 mb-1">اسم النظام</label>
                    <input type="text" name="app_name" value="{{ config('app.name') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-600 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="app_email" value="{{ config('mail.from.address') }}"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full shadow-lg">
                    حفظ التغييرات
                </button>
            </form>
        </div>
    </div>
@endsection
