@if(session('success'))
    <div id="flash"
         class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-lg text-sm mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="flash"
         class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded-lg text-sm mb-4">
        {{ session('error') }}
    </div>
@endif

<script>
    setTimeout(() => {
        const el = document.getElementById('flash');
        if (el) el.remove();
    }, 3000);
</script>
