<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManageApp;
use Setting;
class ManageappController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        try{
            
            $Demoapp = ManageApp::all();
            if($request->ajax()){
            	return $Demoapp;
            }
            return view('admin.demoapp.index', compact('Demoapp'));  
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $code
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {	
    	$this->validate($request, [
            'code' => 'required',
        ]);
        try {
            $DemoApp = ManageApp::where('pass_code',$request->code)->first();
                return $DemoApp?:[];
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Invalid Code!');
        } catch (Exception $e) {
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
       return view('admin.demoapp.create'); 
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
            'pass_code' => 'required',
            'status' => 'required',
            'base_url' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required'
        ]);
        try {
            $ManageApp = ManageApp::create([
                'pass_code' => $request->pass_code,
                'status' => $request->status,
                'base_url' => $request->base_url,
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                
            ]);     
            return back()->with('flash_success', trans('form.resource.created'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
       try {
            $OrderDispute = $request->user()->disputes->find($id);
            if($request->ajax()){
                return $OrderDispute?:[];
            }
            return view(Route::currentRouteName(), compact('OrderDispute'));
        } catch (ModelNotFoundException $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', 'Order not found!');
        } catch (Exception $e) {
            if($request->ajax()){
                return response()->json(['error' => trans('form.whoops')]);
            }
            return back()->with('flash_error', trans('form.whoops'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {	
    	$Demoapp = ManageApp::findOrFail($id);
        return view('admin.demoapp.edit',compact('Demoapp')); 
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
        $Demoapp = ManageApp::findOrFail($id);
        $this->validate($request, [
            'pass_code' => 'required',
            'status' => 'required',
            'base_url' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required'
        ]);
        try {
            
            $Demoapp->pass_code = $request->pass_code;
            $Demoapp->status =  $request->status;
            $Demoapp->base_url =  $request->base_url;
            $Demoapp->client_id =  $request->client_id;
            $Demoapp->client_secret =  $request->client_secret;
            $Demoapp->save(); 
            return back()->with('flash_success', trans('form.resource.updated'));
        } catch (ModelNotFoundException $e) {
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
        //
    }


    public function setting(){
        return Setting::all();
    }
}
