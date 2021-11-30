@extends('canvas')
@section('title', 'My purchases')
@section('title_header', 'Listing your past purchases')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allPurchases.css') }}"/>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert success">{{Session::get('success')}}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert error">{{Session::get('error')}}</div>
    @endif
    <table id="purchases_list">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date of purchase</th>
            <th>Seller</th>
            <th>Address of items</th>
            <th>Action</th>
        </tr>

        @foreach($purchases as $purchase)
            <tr>
                <td>{{$purchase->offer_title}}</td>
                <td>{{$purchase->offer_quantity}}</td>
                <td>{{$purchase->offer_price}} €</td>
                <td>{{date_format(new DateTime($purchase->created_at),'g:ia \o\n l jS F Y')}}</td>
                <td>{{$purchase->offer_vendor}}</td>
                <td>{{$purchase->offer_address}}</td>
                <td>
                    <form action="{{route('purchases.destroy',$purchase)}}" method="POST">
                        @CSRF
                        @method("DELETE")
                        <button class="btn btn-red">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>
@endsection()
