@extends('canvas')
@section('title', 'Authentification')
@section('title_header', 'Connexion au Maraîcher-Esi')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div id="login">
        <form action="/web/offers" method="POST">
            <div class="container">
                <input type="text" placeholder="Enter Username" name="uname" required>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <button id="button_login" type="submit">Login</button>
            </div>
        </form>
        <div class="container">
            <button id="inscription" type="button">Pas de compte ?</button>
        </div>
    </div>
    <div id="register">
        <form action="/web/offers" method="POST" >
            <div class="container">
                <input type="text" placeholder="Enter Username" name="uname" required>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <input type="password" placeholder="Repete Password" name="repetepsw" required>
                <input type="text" placeholder="Enter your email" name="gmail" required>
                <button type="submit">Login</button>

            </div>
        </form>
        <div class="container">
            <button id="connexion" type="button" >Déjà un compte ?</button>
        </div>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>


    <script>
        $("#inscription").on('click',function(){
            $("#register").show()
            $("#login").hide()
            $("header h1").text("Inscription au Maraîcher-Esi")
        })

        $("#connexion").on('click',function(){
            $("#register").hide()
            $("#login").show()
            $("header h1").text("Connexion au Maraîcher-Esi")
        })
    </script>
@endsection
