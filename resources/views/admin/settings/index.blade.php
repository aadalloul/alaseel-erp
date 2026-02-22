@extends('layouts.admin')

@section('content')

    @if(session('success'))

        <div style="color:green">
            {{ session('success') }}
        </div>

    @endif


    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')


        <input type="text" name="site_name"
               value="{{ $settings->site_name ?? '' }}"
               placeholder="اسم الموقع">

        <br><br>


        <input type="email" name="email"
               value="{{ $settings->email ?? '' }}"
               placeholder="البريد">

        <br><br>


        <input type="text" name="phone"
               value="{{ $settings->phone ?? '' }}"
               placeholder="الهاتف">

        <br><br>


        <input type="file" name="logo">

        <br><br>


        @if(!empty($settings->logo))

            <img src="{{ asset('storage/'.$settings->logo) }}" width="150">

        @endif


        <br><br>

        <button type="submit">

            حفظ

        </button>


    </form>


@endsection
