@extends('layouts.admin')

@section('title', 'تعديل صلاحيات الدور')

@section('content')

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- العنوان --}}
        <div class="bg-gradient-to-r from-purple-600 to-indigo-500 rounded-2xl p-6 text-white shadow">
            <h1 class="text-2xl font-bold">تعديل صلاحيات الدور</h1>
            <p class="opacity-80 mt-1">
                الدور: {{ $role->name }}
            </p>
        </div>

        {{-- رسالة نجاح --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- النموذج --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block mb-4 font-semibold text-lg">
                        الصلاحيات
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($permissions as $permission)
                            <label
                                class="flex items-center gap-3 border rounded-xl p-3 cursor-pointer
                                   hover:bg-indigo-50 dark:hover:bg-gray-700 transition">

                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       class="w-5 h-5 text-indigo-600"
                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                                <span class="font-medium">
                                {{ $permission->label ?? $permission->name }}
                            </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- زر الحفظ --}}
                <button
                    class="bg-gradient-to-r from-purple-600 to-indigo-500 text-white px-8 py-2 rounded-lg shadow hover:opacity-90 transition">
                    💾 حفظ الصلاحيات
                </button>

            </form>
        </div>

    </div>

@endsection
