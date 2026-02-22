@extends('layouts.admin')

@section('title', 'تعديل الإعداد')

@section('content')
    <div class="max-w-lg mx-auto space-y-6">

        <h1 class="text-2xl font-bold">تعديل الإعداد: {{ $setting->key }}</h1>

        <form action="{{ route('settings.update', $setting->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-semibold">القيمة</label>
            <input type="text" name="value" value="{{ old('value', $setting->value) }}"
                   class="w-full border rounded px-4 py-2 mb-4">

            @error('value')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">💾 حفظ</button>
            <a href="{{ route('settings.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded">عودة</a>
        </form>

    </div>
@endsection
