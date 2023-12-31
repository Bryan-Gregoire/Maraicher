<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Offer;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {   //ORDER BY => choisir le critère d'ordre
        $offers = Offer::orderBy('expirationDate', 'desc')->where('expirationDate', '>=', date('Y-m-d H:i:s'))->get();
        return view('offers.index')->with(['offers' => $offers]);
    }

    public function index_personal()
    {
        $user = auth()->user();
        $offers = Offer::where('user_id', $user->id)
            ->where('expirationDate', '>=', date('Y-m-d H:i:s'))
            ->orderBy('expirationDate', 'desc')
            ->get();
        return view('offers.myOffers')
            ->with(['user' => auth()->id(), 'offers' => $offers]);
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
     * @return Application|RedirectResponse|\Illuminate\Http\Response|Redirector
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'amount' => 'required',
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
        $adress = Address::make([
            'address_string' => $request['address'],
        ]);
        $adress->save();
        $user = User::find(auth()->id());
        $user->addresses()->attach($adress);
        $user->save();

        return redirect(route('offers.myOffers'))->with('success', 'New offer added !');
    }

    /**
     * Display the specified resource.
     *
     * @param Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * update the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Offer $offer
     * @return Application|RedirectResponse|\Illuminate\Http\Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);
        $offer->update([
            "title" => $request->all()['name'],
            "price" => $request->all()['price'],
            "quantity" => $request->all()['amount'],
            "expirationDate" => $request->all()['timeleft'],
            "address" => $request->all()['address'],
        ]);

        return redirect(route('offers.myOffers'))->with('Success', "The offer has been update.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Offer $offer
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect(route('offers.myOffers'))->with('Success', "The offer has been deleted.");
    }


    public function search(Request $request)
    {
        $search = Offer::whereRaw('LOWER(title) LIKE ? ', ['%' . strtolower($request['search_bar']) . '%'])
            ->orderBy('expirationDate', 'desc')->where('expirationDate', '>=', date('Y-m-d H:i:s'))->get();
        return \view('offers.index')->with(['offers' => $search,])->with(['oldValue' => $request['search_bar']]);
    }

}
