@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
    <div class="space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">المستخدمين</h1>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
            <table class="datatable w-full text-gray-700 dark:text-gray-200 text-center">
                <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الأدوار</th>
                    <th>الصلاحيات</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $index => $user)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-200 px-2 py-1 rounded-full text-xs inline-block mr-1 mb-1">
                                {{ $role->name }}
                            </span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($user->permissions as $permission)
                                <span class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200 px-2 py-1 rounded-full text-xs inline-block mr-1 mb-1">
                                {{ $permission->label ?? $permission->name }}
                            </span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('admin.users.editRoles', $user->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg transition">
                                تعديل الصلاحيات
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
