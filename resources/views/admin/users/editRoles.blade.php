@extends('layouts.admin')

@section('title', 'تعديل الدور والصلاحيات')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- العنوان -->
        <div class="bg-gradient-to-r from-blue-600 to-teal-500 rounded-2xl p-6 shadow text-white">
            <h1 class="text-2xl font-bold">تعديل الدور والصلاحيات للمستخدم: {{ $user->name }}</h1>
            <p class="opacity-80 mt-1">اختر الدور والصلاحيات الجديدة لهذا المستخدم</p>
        </div>

        <!-- النموذج -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <form action="{{ route('admin.users.updateRoles', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- الدور -->
                <div class="mb-6">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">الدور</label>
                    <select name="role" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 dark:bg-gray-700 dark:text-white">
                        <option value="">بدون دور</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- الصلاحيات -->
                <div class="mb-6">
                    <label class="block mb-4 font-semibold text-gray-700 dark:text-gray-200">الصلاحيات</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($permissions as $permission)
                            <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                       class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
                                    {{ $user->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}>
                                <span class="font-medium text-gray-700 dark:text-gray-200">
                                {{ $permission->label ?? $permission->name }}
                            </span>
                            </label>
                        @endforeach
                    </div>
                    @error('permissions')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- زر الحفظ -->
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-teal-500 text-white px-6 py-2 rounded-xl shadow hover:from-blue-700 hover:to-teal-600 transition">
                    💾 تحديث
                </button>
            </form>
        </div>
    </div>
@endsection
