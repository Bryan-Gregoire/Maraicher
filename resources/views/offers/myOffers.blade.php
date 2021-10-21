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

    <form id="offers" action="" method="POST">
        @CSRF
        <input type="text" placeholder="Name" name="name" required>
        <input type="number" placeholder="Amount" name="amount" required>
        <input type="number" placeholder="Price" name="price" required>
        <input type="date" name="timeleft" required>
        <button class="btn-submit">Add an offer</button>
    </form>

    <table id="offers_list">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Price</th>
            <th>Time left</th>
            <th>Action</th>
        </tr>

        <tr>
            <td>1</td>
            <td>Légumes</td>
            <td>10x</td>
            <td>15 €</td>
            <td>5 days</td>
            <td>
                <form action="/delete" method="POST">
                    @CSRF
                    <button class="btn btn-red">Delete</button>
                </form>
            </td>
        </tr>

        <tr>
            <td>2</td>
            <td>Fruits</td>
            <td>1x</td>
            <td>1 €</td>
            <td>1 day</td>
            <td>
                <form action="/buy" method="POST">
                    @CSRF
                    <button class="btn btn-red">Delete</button>
                </form>
            </td>
        </tr>
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

