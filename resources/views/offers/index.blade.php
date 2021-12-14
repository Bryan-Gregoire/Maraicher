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

    <form id="search" method="POST" action="{{route('search_bar')}}">
        @CSRF
        <div class="inptBar">
            <input id="inputBar" type="text" name="search_bar" placeholder="Search Bar" value="{{ isset($oldValue) ? $oldValue : ""}}">
        </div>
        <button id="buttonSearch" class="btn btn-green">Rechercher</button>
    </form>
    <table id="offers_list">
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Expiration Date</th>
            <th>Expiration Time</th>
            <th>Offer address</th>
            <th>User</th>
            <th>Action</th>
        </tr>

        @foreach($offers as $offer)
            @php
                $offerId = $offer->id;
                $hasReservation = \App\Models\Reservation::where('offer_id',$offerId)->exists() &&
                \App\Models\Reservation::where('offer_id',$offerId)->first()->users->contains(auth()->id())
            @endphp
            <tr>
                <td>{{$offer->title}}</td>
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
                    $formatted_date = "Today" ;
                    $formatted_time = date_format($given_date, 'g:ia');
                } else if ($given_date >= $tomorrow_midnight && $given_date <= $tomorrow_end) {
                    $formatted_date = "Tomorrow ";
                    $formatted_time = date_format($given_date, 'g:ia');
                } else if ($given_date >= $after_tomorrow_midnight && $given_date <= $after_tomorrow_end) {
                    $formatted_date = "After tomorrow ";
                    $formatted_time = date_format($given_date, 'g:ia');
                } else {
                    $formatted_date = date_format($given_date, 'Y-m-d');
                    $formatted_time = date_format($given_date, 'g:i a');
                }
                ?>
                <td>{{$formatted_date}}</td>
                <td>{{$formatted_time}}</td>
                <td>{{$offer->address}}</td>
                <td>{{$offer->user->name}}</td>
                <td>
                    @if($offer->user->id == auth()->id())
                        @php
                            $count
=  \App\Models\Reservation::where('offer_id',$offerId)->exists()
? \App\Models\Reservation::where('offer_id',$offerId)->first()->users->count()
: 0;
                        @endphp
                        @if(!App\Models\Reservation::where('offer_id',$offerId)->exists() && !\App\Models\Purchase::where('offer_id',$offer->id)->exists())
                            <span><strong>{{$count}} bids</strong></span>
                        @elseif(\App\Models\Purchase::where('offer_id',$offer->id)->exists() && !App\Models\Reservation::where('offer_id',$offerId)->exists())

                            <span><strong>SOLD</strong></span>
                        @else
                            <a href="{{ route('reservations.show',\App\Models\Reservation::where('offer_id',$offerId)->first()) }}">
                                <span class="bidsClick"><strong>{{$count}} bids</strong></span>
                            </a>
                        @endif

                    @elseif(\App\Models\Purchase::where('offer_id',$offer->id)->exists())
                        <span><strong>SOLD</strong></span>
                    @elseif ($hasReservation )
                        <span><strong>You have reserved</strong></span>

                    @else
                        <form action="{{route('reservations.store')}}" method="POST">
                            @CSRF
                            <input type="hidden" name="user_id" value="{{auth()->id()}}">
                            <input type="hidden" name="offer_id" value="{{$offer->id}}">
                            <button class="btn btn-green">Book</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection()
