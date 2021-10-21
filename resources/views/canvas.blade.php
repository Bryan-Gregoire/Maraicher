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
    @guest
        <h1>@yield('title_header')</h1>
    @endguest
</header>

<nav>
    <a href="/offers"><i class="fa fa-list"></i> Offers</a>
    <a href="/offers/myOffers"><i class="fa fa-address-book"></i> Account</a>
    <a href="/"><i class="fa fa-sign-out"></i> Sign out</a>

</nav>

<main>
    @yield('content')
</main>

@yield('script')
</body>
