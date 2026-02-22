@extends('layouts.admin')

@section('title', 'إدارة الأدوار والصلاحيات')

@section('content')
    <div class="space-y-6">

        <!-- عنوان الصفحة وزر إضافة دور جديد -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">الأدوار والصلاحيات</h1>
            <a href="{{ route('admin.roles.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                <i class="fa fa-plus mr-2"></i> إضافة دور جديد
            </a>
        </div>

        <!-- جدول الأدوار -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
            <table class="datatable w-full text-gray-700 dark:text-gray-200">
                <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-center">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">اسم الدور</th>
                    <th class="px-4 py-2">الصلاحيات</th>
                    <th class="px-4 py-2">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $index => $role)
                    <tr class="border-b border-gray-200 dark:border-gray-700 text-center">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ ucfirst($role->name) }}</td>
                        <td class="px-4 py-2">
                            @foreach($role->permissions as $permission)
                                <span class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200 px-2 py-1 rounded-full text-xs mr-1 mb-1 inline-block">
                            {{ $permission->label ?? $permission->name }}
                        </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg transition">
                                تعديل
                            </a>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/dark/1.0.1/dark.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/dark/1.0.1/dataTables.dark.min.js"></script>

    <!-- تعديل محاذاة الجدول -->
    <style>
        table.dataTable th, table.dataTable td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                responsive: true,
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json'
                }
            });
        });
    </script>
@endsection
