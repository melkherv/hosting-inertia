<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Requests\ProviderTokenRequest;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Providers/Providers', [
            'providers' => Provider::all(),
            'userProviders' => auth()->user()->providers
        ]);
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
     * Method store
     *
     * @param ProviderTokenRequest
     *
     * @return void
     */
    public function store(ProviderTokenRequest $request)
    {
        $user = $request->user();

        $provider = Provider::where('name', $request->input('providerName'))->first();

        $user->providers()->attach($provider->id, ['token' => $request->input('token')]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function updateToken(ProviderTokenRequest $request)
    {
        $user = $request->user();

        $provider = Provider::where('name', $request->input('providerName'))->first();

        $user->providers()->updateExistingPivot($provider->id, ['token' => $request->input('token')]);
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

    /**
     * Method deleteToken
     *
     * @param Request $request
     *
     * @return void
     */
    public function deleteToken(Request $request)
    {
        $user = $request->user();

        $provider = Provider::whereName($request->input('providerName'))->first();

        $user->providers()->detach($provider);
    }
}
