<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Route;
use Exception;
use App\Addon;
class AddonsResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
         
        $Addons = Addon::where('shop_id',$request->shop)->get();

        if($request->ajax()){
            return $Addons ;
        }
        return view(Route::currentRouteName(), compact('Addons'));
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
            'name' => 'required|string|max:255',
            //'avatar' => 'required|image|max:2120',
        ]);

        try {
            $Addon = $request->all();
            if($request->hasFile('avatar')) {
                $Addon['avatar'] = asset('storage/'.$request->avatar->store('addons'));
            }
            
           
            
            $Addon = Addon::create($Addon);
            
           
            return back()->with('flash_success', trans('inventory.addons.created_success',['name'=>$Addon->name]));
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
            $Addon = Addon::findOrFail($id);
            return view(Route::currentRouteName(), compact('Addon'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.shops.index')->with('flash_error', 'Shop not found!');
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            // return redirect()->route('admin.shops.index')->with('flash_error', trans('form.whoops'));
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
                'name' => 'required|string|max:255',
                'avatar' => 'image|max:2120',
            ]);

        try {
            $Addon = Addon::findOrFail($id);
            $Update = $request->all();
            if($request->hasFile('avatar')) {
                $Update['avatar'] = asset('storage/'.$request->avatar->store('addons'));
            } else {
                unset($Update['avatar']);
            }
           
            
            $Addon->update($Update);
            //Cuisine
           
            
            
            return back()->with('flash_success', trans('inventory.addons.updated_success',['name'=>$Addon->name]));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
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
            $Addon = Addon::findOrFail($id);
            $Addon->delete();
            return back()->with('flash_success', trans('inventory.addons.remove'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.shops.index')->with('flash_error', 'Shop not found!');
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
