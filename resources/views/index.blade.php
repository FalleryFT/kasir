<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="login.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Kasirkan</title>
    <style>
        body {
            font-family: 'Lato', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url("/images/img.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-color: #000;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(5px);
            z-index: -1;
        }

        .container {
            max-width: 524px;
            max-height: 436px;
            margin: 20px auto;
            display: grid;
            gap: 25px;
            padding: 0;
        }

        .card {
            background-color: #fff;
            border: 2px solid #fff;
            padding: 20px;
            text-align: center;
            border-radius: 31px;
        }

        .card img {
            max-width: 50%;
            height: auto;
        }

        .card h2 {
            margin-top: 5px;
            color: #363636;
            font-size: 29.52px;
        }

        .isi {
            border: 2px solid #9A9A9A;
            border-radius: 7.38px;
            color: #9A9A9A;
            font-size: 16.61px;
            margin-bottom: 10px;
            width: 454.97px;
            height: 44.28px;
            padding-left: 10px;
        }

        .kirim {
            border: 2px solid #2196F3;
            border-radius: 7.38px;
            background-color: #2196F3;
            color: #fff;
            font-size: 18.45px;
            font-weight: bold;
            margin-bottom: 10px;
            width: 470.97px;
            height: 44.28px;
        }

        .kirim:hover {
            color: #2196F3;
            background-color: #fff;
            border: 2px solid #2196F3;
        }


        @media (max-width:520px) {

            .card img {
                max-width: 28%;
            }

            .isi {
                width: 310px;
                height: 40px;
            }

            .kirim {
                width: 326px;
                height: 40px;
            }

        }
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif;">

<form class="container" action="{{ route('login.auth') }}" method="POST">
    @csrf
    <div class="card">
        <!-- Logo -->
        <img src="{{ asset('images/Frame.png') }}" alt="Logo">

        <h2 class="text-2xl font-bold text-gray-700 mb-4">Login</h2>

        <!-- Alert Error -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 w-full text-center text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Input Email -->
        <input type="text" name="email" id="email" class="isi w-full border p-2 rounded-lg mb-3 focus:ring focus:ring-blue-300 @error('email') border-red-500 @enderror" placeholder="Masukkan Email" value="{{ old('email') }}">
        
        <!-- Input Password -->
        <input type="password" name="password" id="password" class="isi w-full border p-2 rounded-lg mb-3 focus:ring focus:ring-blue-300" placeholder="Masukkan Password">

        <!-- Tombol Kirim -->
        <button type="submit" class="kirim">
            Kirim
        </button>
    </div>
</form>
</body>
</html>
