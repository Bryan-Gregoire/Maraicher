<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Reservation;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function store(Request $request)
    {
        $offerId = $request->offer_id;
        $userId = $request->user_id;
        if (Reservation::where('offer_id', $offerId)->exists()) {
            Reservation::where('offer_id', $offerId)->first()->users()->attach(User::find($userId));
        } else {
            $newRes = Reservation::make([
                'offer_id' => $offerId
            ]);
            $newRes->save();
            $newRes->users()->attach(User::find($userId));
            $newRes->save();

        }
        $offers = Offer::orderBy('expirationDate', 'desc')->where('expirationDate', '>=', date('Y-m-d H:i:s'))->get();
        return view('offers.index')->with(['offers' => $offers]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reservation $reservation
     * @return Application|Factory|View|Response
     */
    public function show(Reservation $reservation)
    {
        return view('offers.reservation')->with(['reservation' => $reservation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Reservation $reservation
     * @return Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Reservation $reservation
     * @return Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reservation $reservation
     * @return Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }


    public function selectUser(Request $request)
    {
        $offerId = $request->offerId;
        $offer = Offer::find($offerId);
        $chosenUser = $request->chosenCustomer;
        $reservation = Reservation::where('offer_id', $offerId)->first()->delete();
        $newSale = Purchase::create(
            [
                'user_id' => $chosenUser,
                'offer_title' => $offer->title,
                'offer_price' => $offer->price,
                'offer_quantity' => $offer->quantity,
                'offer_address' => $offer->address,
                'offer_vendor' => $offer->user->name,
                'offer_id' => $offer->id,
            ]);
        $name = User::find($chosenUser)->name;
        $offers = Offer::orderBy('expirationDate', 'desc')->where('expirationDate', '>=', date('Y-m-d H:i:s'))->get();
        return view('offers.index')->with('success', "Sold to $name")->with('offers', $offers);
    }
}
