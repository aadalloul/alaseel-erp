<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مرحبًا | ميزان</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .loader {
            border: 5px solid #e5e7eb;
            border-top: 5px solid #ffffff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
    </style>
</head>

<body class="bg-gradient-to-br  flex items-center justify-center min-h-screen">

<div class="bg-white/95 backdrop-blur rounded-3xl shadow-2xl p-12 text-center w-full max-w-md">

    <!-- Logo -->
    <img src="{{ asset('logo.png') }}" class="w-100 mx-auto mb-6">

    <h2 class="text-2xl font-bold text-blue-700 mb-2">
           ميزان للحلول المالية والإدارية
    </h2>

    <p class="text-gray-500 mb-8">
        اجعل عملية التقارير المالية أكثر شفافية وسهولة
    </p>

    <div class="loader mb-4"></div>

    <p class="text-sm text-gray-400">جاري التحميل...</p>
</div>

<script>
    setTimeout(() => {
        window.location.href = "{{ route('login') }}";
    }, 5000); // بعد 2.5 ثانية
</script>

</body>
</html>
