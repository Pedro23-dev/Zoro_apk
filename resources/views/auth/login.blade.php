<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tp salaire</title>
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:700,600" rel="stylesheet" type="text/css" />



<form method="post" action="{{route('handleLogin')}}">

    @csrf
    @method('POST')

    <div class="box">
        <h1>Espace de connexion</h1>

        {{-- {{Hash::make('azerty')}}   --}}

  @if (Session::get('success'))
        <b style="font-size: 15px; color:green; font-style:italic">{{Session::get('success')}}</b>
        @endif
  @if (Session::get('error_msg'))
        <b style="font-size: 10px; color:red">{{Session::get('error_msg')}}</b>
        @endif
  @if (Session::get('success_msg'))
        <b style="font-size: 10px; color:green">{{Session::get('success_msg')}}</b>
        @endif

        <input type="email" name="email" class="email" value="{{ old('email') }}" placeholder="votremail@gmail.com">

        <input type="password" name="password" class="email" value="{{ old('password') }}" placeholder="votre mot de passe" >

        <div class="btn-container">
            <button type="submit">Connexion</button>
        </div>

        <!-- End Btn -->
        <!-- End Btn2 -->
    </div>
    <!-- End Box -->
</form>

</body>
</html>
