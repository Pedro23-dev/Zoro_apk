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



<form method="post" action="{{route('submitDefineAccess', $email)}}">

    @csrf
    @method('POST')

    <div class="box">
        <h1>Definissez vos accès</h1>

        {{-- {{Hash::make('azerty')}}   --}}

  @if (Session::get('error_msg'))
        <b style="font-size: 10px; color:red">{{Session::get('error_msg')}}</b>
        @endif

       <div class="form-group">
        <label for="">Email</label>
         <input type="email" name="email" class="email" value="{{ $email }}"  placeholder="votremail@gmail.com" readonly>
       </div>
       <div class="form-group">
        <label for="">Code</label>
         <input type="text" name="code" class="email" value="{{ old('code') }}" >
                 @error('code')
        <span class=" text-danger">{{ $message }}</span>
         @enderror
       </div>
       <div class="form-group">
        <label for="">Mot de passe</label>
         <input type="password" name="password" class="password"  >
         @error('password')
        <span class="text-danger">{{ $message }}</span>
         @enderror
       </div>
       <div class="form-group">
        <label for="">Mot de passe de confirmation</label>
          <input type="password" name="confirm_password" class="email" placeholder="votre mot de passe" >
             @error('confirm_password')
        <span class=" text-danger">{{ $message }}</span>
         @enderror
       </div>



        <div class="btn-container">
            <button type="submit">Valider</button>
        </div>

        <!-- End Btn -->
        <!-- End Btn2 -->
    </div>
    <!-- End Box -->
</form>

</body>
</html>
<style>
    .form-group{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        
        }
    .text-danger{
        color: red !important;
    }
</style>
