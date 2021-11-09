@extends('canvas')
@section('title', 'My Offers')
@section('title_header', 'Listing my offers on Maraîcher-ESI')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')

<div id="addOffer" class="normal-btn" style="width: 50%; margin: 0 auto; margin-top: 60px;">
    Add an offer
</div>
@if (Session::has('success'))
<div class="alert success">{{Session::get('success')}}</div>
@endif
@if (Session::has('error'))
<div class="alert error">{{Session::get('error')}}</div>
@endif
<form id="offers" action="{{route('offers.store')}}" method="POST">
    @CSRF
    <input type="text" placeholder="Name" name="name" required>
    <input type="text" placeholder="Amount" name="amount" required>
    <input type="number" placeholder="Price" name="price" required>
    <input type="date" name="timeleft" required id="myDate" value="2022-08-14">
    <input type="text" placeholder="address" name="address" required>
    <button class="btn-submit">Add an offer</button>
</form>

<table id="offers_list">
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Expiration Date</th>
        <th>Offer address</th>
        <th>Action</th>
    </tr>
    @foreach($offers as $count=> $offer)
    <tr>
        <td contenteditable="true">{{$offer->title}}</td>
        <td contenteditable="true">{{$offer->quantity}}</td>
        <td contenteditable="true">{{$offer->price}} €</td>
        <td contenteditable="true">{{$offer->expirationDate}}</td>
        <td contenteditable="true">{{$offer->address}}</td>
        <td>
            <form action="{{route("offers.destroy",$offer)}}" method="POST">
                @CSRF
                @method('DELETE')
                <button class="btn btn-red">Delete</button>
            </form>
            <form action="{{route("offers.update", $offer)}}" method="POST">
                @CSRF
                @method('PATCH')
        <input type="hidden" name="title" value="{{$offer->title}}"/>
        <input type="hidden" name="title" value="{{$offer->quantity}}"/>
        <input type="hidden" name="title" value="{{$offer->price}}"/>
        <input type="hidden" name="title" value="{{$offer->expirationDate}}"/>
        <input type="hidden" name="title" value="{{$offer-> address}}"/>

        <button class="btn btn-orange">Modify</button>
        </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection()

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(window).on('load', function() {
        $("#addOffer").on('click', function() {
            $("#offers").show(200)
            $("#addOffer").hide()
        })
    })
    document.getElementById("myDate").min = new Date().getFullYear() + "-" + parseInt(new Date().getMonth() + 1) + "-" +
        new Date().getDate()
</script>
@endsection