<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>جاري التحميل - أصيل</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .fade-text {
            animation: fadeInOut 4s infinite;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(10px);}
            20% { opacity: 1; transform: translateY(0);}
            80% { opacity: 1; }
            100% { opacity: 0; transform: translateY(-10px);}
        }
    </style>
</head>

<body class="bg-white flex items-center justify-center h-screen">

<div class="text-center space-y-6">

    <!-- لوجو -->
    <img src="{{ asset('logo.png') }}" class="mx-auto w-60 md:w-72 lg:w-80 drop-shadow-xl">

    <!-- دائرة التحميل -->
    <div class="flex justify-center">
        <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- النص المتغير -->
    <p id="loadingText" class="fade-text text-gray-700 text-lg font-semibold"></p>

</div>

<script>
    const messages = [
        "استمتع بوصول آمن ومُشفّر لبياناتك من أي مكان وفي أي وقت",
        "اجعل عملية التقارير المالية أكثر شفافية وسهولة مع أصيل",
        "قوائم مالية وحسابات ختامية تفاعلية تُتيح لك تحليل بياناتك بسهولة"
    ];

    let i = 0;
    const textElement = document.getElementById("loadingText");

    setInterval(() => {
        textElement.innerText = messages[i];
        i = (i + 1) % messages.length;
    }, 2000);

    // تحويل تلقائي لصفحة تسجيل الدخول بعد 8 ثواني
    setTimeout(() => {
        window.location.href = "{{ route('login') }}";
    }, 8000);
</script>

</body>
</html>
