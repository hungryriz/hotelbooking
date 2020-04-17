<?php

namespace App\Http\Controllers\Resource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Promocode;
use Route;
use Exception;

class PromocodeResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $Promocodes = Promocode::all();
            return view(Route::currentRouteName(), compact('Promocodes'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(Route::currentRouteName());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'promo_code' => 'required|string|max:255|unique:promocodes',
            'promocode_type' => 'required|in:amount,percent',
            'discount' => 'required',
            'coupon_limit' => 'required',
            'coupon_user_limit' => 'required',
            'avail_from' => 'required',
            'expiration' => 'required',
            'status' => 'required|in:ADDED,EXPAIRED'
        ]);

        try {
            $Promocode = $request->all();
            $Promocode = Promocode::create($Promocode);
            return back()->with('flash_success', trans('form.resource.created'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
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
        try {
            $Promocode = Promocode::findOrFail($id);

            return view(Route::currentRouteName(), compact('Promocode'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
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
        $this->validate($request, [
                'expiration' => 'required',
                'status' => 'required',
                'promocode_type' => 'required',
                'discount' => 'required',
            ]);

        try {
            $Promocode = Promocode::findOrFail($id);
            $Update = $request->all();
            $Promocode->update($Update);
            return back()->with('flash_success', trans('form.resource.updated'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.resource.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try {
            $Promocode = Promocode::findOrFail($id);
            // Need to delete variants or have them re-assigned
            $Promocode->delete();
            return back()->with('flash_success', trans('form.resource.deleted'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
