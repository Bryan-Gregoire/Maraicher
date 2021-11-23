@extends('canvas')
@section('title', 'My Offers')
@section('title_header', 'Listing my offers on Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')

    <div id="addOffer" class="normal-btn addOfferButton">
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
        <input type="datetime-local" name="timeleft" required id="myDate" value="2022-08-14 05:55">
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

                <?php
                $given_date = new DateTime($offer->expirationDate);

                $now_midnight = new DateTime('today midnight');
                $now_end = (new DateTime('today midnight'))->modify("+23 hours")->modify("+59 minutes");
                $tomorrow_midnight = new DateTime('tomorrow midnight');
                $tomorrow_end = (new DateTime('tomorrow midnight'))->modify("+23 hours")->modify("+59 minutes");
                $after_tomorrow_midnight = (new DateTime('tomorrow midnight'))->modify("+1 day");
                $after_tomorrow_end = (new DateTime('tomorrow midnight'))
                    ->modify("+1 day")->modify("+23 hours")->modify("+59 minutes");

                if ($given_date >= $now_midnight && $given_date <= $now_end) {
                    $formatted_date = "Today at " . date_format($given_date, 'g:ia');
                } else if ($given_date >= $tomorrow_midnight && $given_date <= $tomorrow_end) {
                    $formatted_date = "Tomorrow at " . date_format($given_date, 'g:ia');
                } else if ($given_date >= $after_tomorrow_midnight && $given_date <= $after_tomorrow_end) {
                    $formatted_date = "After tomorrow at " . date_format($given_date, 'g:ia');
                } else {
                    $formatted_date = date_format($given_date, 'Y-m-d, g:i a');
                }
                ?>
                <td>{{$formatted_date}}</td>
                <td>{{$offer->address}}</td>
                <td id="buttons">
                    <form action="{{route("offers.destroy",$offer)}}" method="POST">
                        @CSRF
                        @method('DELETE')
                        <button id="deleteOffer" class="btn btn-red">Delete</button>
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
                $("#buttonAdd").text("Update offer")
                let tr = (btn.parent().parent())

                $("#name").val(tr.attr("data-title"))
                $("#amount").val(tr.attr("data-quantity"))
                $("#price").val(tr.attr("data-price"))
                $("#myDate").val(tr.attr("data-expDate").slice(0, -3).replace(" ", "T"))
                $("#adresse").val(tr.attr("data-address"))
                $("#offers").attr("action", "/offers/" +tr.attr("data-idOffre"))
                $("#offers").append('<input type="hidden" name=id" value="' + tr.attr("data-idOffre") + '">')
                $("#offers").append('<input type="hidden" name="_method" value="PUT">')
        }
    </script>
@endsection
