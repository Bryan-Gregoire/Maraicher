@extends('canvas')
@section('title', 'My Offers')
@section('title_header',  'My Offers')

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
    </table>


@endsection()
