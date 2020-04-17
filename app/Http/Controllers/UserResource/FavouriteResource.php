<?php

namespace App\Http\Controllers\UserResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Favourite;
use Auth;
class FavouriteResource extends Controller
{
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'shop_id' => 'required|exists:shops,id'
            ]);
        \Log::info($request->all());
        try {
            $favourite = new Favourite();
            $favourite->user_id = Auth::user()->id;
            $favourite->shop_id = $request->shop_id;
            $favourite->save();
            if($request->ajax()){
                return $favourite;
            }
           return back()->with('flash_success',trans('form.resource.updated'));
        } catch (ModelNotFoundException $e) {
        	if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }
            return back()->with('flash_failure',trans('form.whoops')); 
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')], 500);
            }
            return back()->with('flash_failure',trans('form.whoops'));
        }
        
    }
}
