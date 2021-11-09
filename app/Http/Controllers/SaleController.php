<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sales = Sale::where('user_id', auth()->id())->get();
        return view('sales.index')->with(['sales' => $sales]);
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
        Sale::create([
            'user_id' => $request->user_id,
            'offer_id' => $request->offer_id,
        ]);
        return redirect(route('offers.index'))->with('success', 'You have bought this order ! ');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Sale $sale
     * @return Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Sale $sale
     * @return Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Sale $sale
     * @return Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Sale $sale
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function destroy(Sale $sale)
    {
        $sale->offer()->delete();
        $sale->delete();
        return redirect(route('sales.my'))->with('success', 'You have deleted this sale from your history ! ');
    }
}
