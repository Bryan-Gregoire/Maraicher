@extends('canvas')
@section('title', 'My Offers')
@section('title_header',  'Listing my offers on Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')

    <div id="addOffer" class="normal-btn" style="width: 50%; margin: 0 auto; margin-top: 60px;">
        Add an offer
    </div>
    @if (Session::has('error'))
        <div class="alert error">{{Session::get('error')}}</div>
    @endif
    <form id="offers" action="{{route('offers.store')}}" method="POST">
        @CSRF
        <input type="text" placeholder="Name" name="name" required>
        <input type="number" placeholder="Amount" name="amount" required>
        <input type="number" placeholder="Price" name="price" required>
        <input type="date" name="timeleft" required>
        <input type="text" placeholder="address" name="address" required>
        <button class="btn-submit">Add an offer</button>
    </form>

    <table id="offers_list">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Time left</th>
            <th>Offer address</th>
            <th>Action</th>
        </tr>
        @foreach($offers as $offer)
            <tr>
                <td>{{$offer->id}}</td>
                <td>{{$offer->title}}</td>
                <td>{{$offer->quantity}}</td>
                <td>{{$offer->price}}</td>
                <td>{{$offer->expirationDate}}</td>
                <td>{{$offer->address}}</td>
                <td>
                    <form action="{{route("offers.destroy",$offer)}}" method="POST">
                        @CSRF
                        @method('DELETE')
                        <button class="btn btn-red">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection()

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(window).on('load', function () {
            $("#addOffer").on('click', function () {
                $("#offers").show(200)
                $("#addOffer").hide()
            })
        })
    </script>
@endsection

