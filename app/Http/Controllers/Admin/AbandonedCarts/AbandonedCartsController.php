<?php

namespace App\Http\Controllers\Admin\AbandonedCarts;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\UserTracking;
use Illuminate\Http\Request;

class AbandonedCartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $source = request('referer');

        $carts = UserTracking::whereIn('action', ['abandonded', 'sent'])
            ->when($source, function ($query, $source) {
                $query->where('referer', 'like', "%{$source}%");
            })
            ->paginate(20);
        $knownSources = ['google', 'instagram', 'twitter', 'facebook'];

        $sourceCounts = [
            'google' => UserTracking::whereIn('action', ['abandonded', 'sent'])
                ->where('referer', 'like', '%google%')->count(),

            'instagram' => UserTracking::whereIn('action', ['abandonded', 'sent'])
                ->where('referer', 'like', '%instagram%')->count(),

            'twitter' => UserTracking::whereIn('action', ['abandonded', 'sent'])
                ->where('referer', 'like', '%twitter%')->count(),

            'facebook' => UserTracking::whereIn('action', ['abandonded', 'sent'])
                ->where('referer', 'like', '%facebook%')->count(),

            'others' => UserTracking::whereIn('action', ['abandonded', 'sent'])
                ->where(function ($query) use ($knownSources) {
                    foreach ($knownSources as $source) {
                        $query->where('referer', 'not like', '%' . $source . '%');
                    }
                })->count(),
        ];
        return view('admin.abandonded_carts.index', compact('carts', 'sourceCounts'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = UserTracking::with('apartment')->find($id);
        return view('admin.abandonded_carts.show', compact('cart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
