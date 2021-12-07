<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Purchase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $purchases = Purchase::where('user_id', auth()->id())->get();
        return view('purchases.index')->with(['purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $offer = Offer::find($request->offer_id);
        $offer->delete();
        Purchase::create([
            'user_id' => $request->user_id,
            'offer_title' => $offer->title,
            'offer_price' => $offer->price,
            'offer_quantity' => $offer->quantity,
            'offer_address' => $offer->address,
            'offer_vendor' => $offer->user->name,
            'offer_id' => $offer->id
        ]);
        return redirect(route('offers.index'))->with('success', 'You have bought this order ! ');

    }

    /**
     * Display the specified resource.
     *
     * @param Purchase $purchase
     * @return Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Purchase $purchase
     * @return Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Purchase $purchase
     * @return Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Purchase $purchase
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Purchase $purchase)
    {
        if (Offer::exists($purchase->offer_id))
            Offer::find($purchase->offer_id)->delete();
        $purchase->delete();
        return redirect(route('purchases.my'))->with('success', 'You have deleted this purchase from your history ! ');
    }
}
