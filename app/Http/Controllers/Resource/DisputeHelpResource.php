<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderDisputeHelp;
use Route;
class DisputeHelpResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $Disputehelp = OrderDisputeHelp::all();
            if($request->ajax()){
                return $Disputehelp;
            }
            return view('admin.disputehelp.index',compact('Disputehelp'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
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
                'type' => 'required'
            ]);
        try {
            $DisputeHelp = OrderDisputeHelp::create([
                    'name' => $request->name,
                    'type' => $request->type
                ]);     
            return back()->with('flash_success', trans('dispute.created_success'));
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
            $Disputehelp = OrderDisputeHelp::findOrFail($id);
            return view(Route::currentRouteName(), compact('Disputehelp'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', 'Product not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.products.index')->with('flash_error', trans('form.whoops'));
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
                'name' => 'required|string|max:255'
            ]);
        try {
            $Disputehelp = OrderDisputeHelp::findOrFail($id);
            $Update = $request->all();
            $Disputehelp->update($Update);
            return back()->with('flash_success', trans('dispute.updated_success'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
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
            $Disputehelp = OrderDisputeHelp::findOrFail($id);
            // Need to delete Cusine 
            $Disputehelp->delete();
            return back()->with('flash_success', trans('form.resource.deleted'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
