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
        <input id="name" type="text" placeholder="Name" name="name" required>
        <input id="amount" type="text" placeholder="Amount" name="amount" required>
        <input id="price" type="number" placeholder="Price" name="price" required>
        <input type="date" name="timeleft" required id="myDate" value="2022-08-14">
        <input id="adresse" type="text" placeholder="address" name="address" required>
        <button id="buttonAdd" class="btn-submit">Add an offer</button>
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
            <tr data-idOffre="{{$offer->id}}" data-title="{{$offer->title}}" data-quantity="{{$offer->quantity}}"
                data-price="{{$offer->price}}" data-expDate="{{$offer->expirationDate}}"
                data-address="{{$offer->address}}">
                <td >{{$offer->title}}</td>
                <td>{{$offer->quantity}}</td>
                <td>{{$offer->price}} €</td>
                <td>{{$offer->expirationDate}}</td>
                <td>{{$offer->address}}</td>
                <td>
                    <form action="{{route("offers.destroy",$offer)}}" method="POST">
                        @CSRF
                        @method('DELETE')
                        <button class="btn btn-red">Delete</button>
                    </form>
                    <button onclick="btnClick($(this))" class="btn btn-orange">Modify</button>
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
        document.getElementById("myDate").min = new Date().getFullYear() + "-" + parseInt(new Date().getMonth() + 1) + "-" +
            new Date().getDate()
    </script>

    <script>
        function btnClick(btn) {
                $("#offers").show(200)
                $("#addOffer").hide()
                $("#buttonAdd").text("update")
                let tr = (btn.parent().parent())

                $("#name").val(tr.attr("data-title"))
                $("#amount").val(tr.attr("data-quantity"))
                $("#price").val(tr.attr("data-price"))
                $("#myDate").val(tr.attr("data-expDate").slice(0, -9))
                $("#adresse").val(tr.attr("data-address"))
                $("#offers").attr("action", "/offers/" +tr.attr("data-idOffre"))
                $("#offers").append('<input type="hidden" name=id" value="' + tr.attr("data-idOffre") + '">')
                $("#offers").append('<input type="hidden" name="_method" value="PUT">')
        }
    </script>
@endsection
