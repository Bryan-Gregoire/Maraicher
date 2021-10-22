<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('css')
    <title>@yield('title')</title>
</head>
</html>

<body>
<header>
        <h1>@yield('title_header')</h1>
</header>

@auth
<nav>
    <a href="/offers"><i class="fa fa-list"></i> Offers</a>
    <a href="/my"><i class="fa fa-address-book"></i> Account</a>
    <form method="POST" action="{{ route('logout') }}">
        @CSRF
        <a href="" onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="fa fa-sign-out"></i> Log out
        </a>
    </form>
</nav>
@endauth

<main>
    @yield('content')
</main>

@yield('script')
</body>
