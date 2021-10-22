<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {   //ORDER BY => choisir le critère d'ordre
        $offers = Offer::orderBy('expirationDate', 'desc')->get();
        return view('offers.index')->with(['user' => auth()->id(), 'offers' => $offers]);
    }

    public function index_personal()
    {
        $user = auth()->user();
        $offers = Offer::where('user_id', $user->id)->orderBy('expirationDate', 'desc')->get();
        return view('offers.myOffers')->with(['user' => auth()->id(), 'offers' => $offers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'amount' => 'required|numeric',
            'price' => 'required|numeric',
            'timeleft' => 'required|date',
            'address' => 'required|min:3|max:255'
        ]);

        if ($validator->fails()) {
            return redirect(route('offers.myOffers'))->with('error', "We cannot add the offer");
        }

        $offer = Offer::create([
            'title' => $request['name'],
            'price' => $request['price'],
            'quantity' => $request['amount'],
            'expirationDate' => $request['timeleft'],
            'address' => $request['address'],
            'user_id' => auth()->id()
        ]);
        return redirect(route('offers.myOffers'))->with('succes', 'New offer added !');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Offer $offer
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect(route('offers.myOffers'))->with('Success', "The offer has been deleted.");
    }
}
