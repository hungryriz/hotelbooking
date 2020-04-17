<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;

use App\Zone;

class ZoneResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Zones = Zone::all();
        return view(Route::currentRouteName(), compact('Zones'));
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
        $this->validate($request , [
                'name' => 'required|max:255',
                'north_east_lat' => 'required|numeric',
                'north_east_lng' => 'required|numeric',
                'south_west_lat' => 'required|numeric',
                'south_west_lng' => 'required|numeric',
            ]);

        try {
            $Zone = Zone::create($request->all());
            return back()->with('flash_success','Availability Zone added successfully');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Whoops! something went wrong.');
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
            $Zone = Zone::findOrFail($id);
            return view(Route::currentRouteName(), compact('Zone'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Availability Zone not found!');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Whoops! something went wrong.');
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
        $this->validate($request , [
            'name' => 'required|max:255',
            'north_east_lat' => 'required|numeric',
            'north_east_lng' => 'required|numeric',
            'south_west_lat' => 'required|numeric',
            'south_west_lng' => 'required|numeric',
        ]);

        try {
            $Zone = Zone::findOrFail($id);
            $Zone->update($request->all());
            return redirect()->route('admin.zones.index')->with('flash_success', 'Zone updated!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.zones.index')->with('flash_error', 'Zone not found!');
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
            $Zone = Zone::findOrFail($id);
            $Zone->delete();

            return back()->with('flash_success','Zone has been deactivated!');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Whoops! something went wrong.');
        }
    }
}
