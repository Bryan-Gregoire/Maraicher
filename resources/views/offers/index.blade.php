@extends('canvas')
@section('title', 'All Offers')
@section('title_header', 'Listing all offers of Maraîcher-ESI')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/allOffers.css') }}">
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert success">{{Session::get('success')}}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert error">{{Session::get('error')}}</div>
    @endif
    <table id="offers_list">

        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Expiration Date</th>
            <th>Offer address</th>
            <th>User</th>
            <th>Action</th>
        </tr>

        @foreach($offers as $offer)
            <tr>
                <td>{{$offer->title}}</td>
                <td>{{$offer->quantity}}</td>
                <td>{{$offer->price}} €</td>
                <td>{{date_format(new DateTime($offer->expirationDate),'g:ia \o\n l jS F Y')}}</td>
                <td>{{$offer->address}}</td>
                <td>{{$offer->user->name}}</td>
                <td>
                    @if($offer->user->id == auth()->id())
                        <span><strong>MINE !</strong></span>
                    @elseif(\App\Models\Sale::where('offer_id',$offer->id)->first())
                        <span><strong>SOLD</strong></span>

                    @else
                        <form action="{{route('sales.store')}}" method="POST">
                            @CSRF
                            <input type="hidden" name="user_id" value="{{auth()->id()}}">
                            <input type="hidden" name="offer_id" value="{{$offer->id}}">
                            <button class="btn btn-green">Buy</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>
@endsection()
