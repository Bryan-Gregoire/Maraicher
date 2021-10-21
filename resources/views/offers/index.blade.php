@extends('canvas')
@section('title', 'All Offers')
@section('title_header', 'All Offers')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')

    <table id="offers_list">
        <tr>
            <th>Id</th>
            <th>Désignation</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Date d'expiration</th>
            <th>Fournisseur</th>
        </tr>
        <div id="myOffers">
            <button id="offers"  onclick="location.href='/offers/myOffers'" style="font-size: 24px"><i class="fa fa-address-book"></i></button>
        </div>
    </table>



    <script>



    </script>
@endsection()
