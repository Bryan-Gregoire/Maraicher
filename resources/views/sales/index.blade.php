@extends('canvas')
@section('title', 'My sales')
@section('title_header', 'Listing your past sales')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/alllSales.css') }}">
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert success">{{Session::get('success')}}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert error">{{Session::get('error')}}</div>
    @endif
    <table id="sales_list">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date of sale</th>
            <th>Seller</th>
            <th>Address of items</th>
            <th>Action</th>
        </tr>

        @foreach($sales as $sale)
            <tr>
                <td>{{$sale->offer->title}}</td>
                <td>{{$sale->offer->quantity}}</td>
                <td>{{$sale->offer->price}} €</td>
                <td>{{date_format(new DateTime($sale->created_at),'g:ia \o\n l jS F Y')}}</td>
                <td>{{$sale->offer->user->name}}</td>
                <td>{{$sale->offer->address}}</td>
                <td>
                    <form action="{{route('sales.destroy',$sale)}}" method="POST">
                        @CSRF
                        @method("DELETE")
                        <button class="btn btn-red">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>
@endsection()
