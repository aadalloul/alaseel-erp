<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#f4f6f9">

<div class="d-flex">

    {{-- Sidebar --}}
    <aside class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
        <h4 class="mb-4 text-center">Admin Panel</h4>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                    Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('profile.edit') }}" class="nav-link text-white">
                    Profile
                </a>
            </li>

            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger w-100">Logout</button>
                </form>
            </li>
        </ul>
    </aside>

    {{-- Main Content --}}
    <main class="flex-fill p-4">

        {{-- ✅ رسائل النجاح / الخطأ --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
