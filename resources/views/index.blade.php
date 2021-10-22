@extends('canvas')
@section('title', 'Authentication')
@section('title_header', 'Connection on Maraîcher-ESI')

@section('content')
    <div id="login">
        <!-- <div class="alert success">Ceci est un succes</div> -->

        <form action="{{ route('login') }}" method="POST">
            @CSRF
            <input type="email" placeholder="Email" name="email" required autofocus>
            <input type="password" placeholder="Password" name="password" required>
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">Remember me
            </label>
            <button class="btn-submit">Login</button>
        </form>
        <div id="button_not_account">Not account ?</div>
    </div>

    <div id="register">
        <!-- <div class="alert error">Ceci est une erreur de register</div> -->

        <form action="" method="POST">
            @CSRF
            <input type="text" placeholder="Name" name="name" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="password" placeholder="Repeat password" name="password_confirmation" required>
            <button class="btn-submit">Register</button>
        </form>
        <div id="button_already_account">Already account ?</div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(window).on('load', function () {
            $("#button_not_account").on('click', function () {
                $("#register").show()
                $("#login").hide()
                $("header h1").text("Register on Maraîcher-ESI")
            })

            $("#button_already_account").on('click', function () {
                $("#register").hide()
                $("#login").show()
                $("header h1").text("Connection on Maraîcher-ESI")
            })
        })
    </script>
@endsection
