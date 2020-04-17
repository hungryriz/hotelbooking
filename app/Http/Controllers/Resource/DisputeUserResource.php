<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Route;
use Exception;
use App\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
class DisputeUserResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $Users = Admin::role('Dispute Manager')->get();
        return view(Route::currentRouteName(), compact('Users'));
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
                'name' => 'required|max:255',
                'email' => 'required|unique:admins|email|max:255',
                'phone' => 'required|unique:admins|string|max:255',
                //'avatar' => 'image',
                'password' => 'required|min:6|confirmed',
            ]);

        try {
            $Admin = $request->all();
            $Admin['password'] = bcrypt($request->password);
            if($request->hasFile('avatar')) {
                $Admin['avatar'] = asset('storage/'.$request->avatar->store('admin/profile'));;
            }
            $Admin = Admin::create($Admin);
            $Admin->assignRole('Dispute Manager');
            // return redirect()->route('admin.Admins.index')->with('flash_success','Admin added successfully');
            return back()->with('flash_success',trans('dispute.user.created_success'));
        } catch (Exception $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Whoops! something went wrong.');
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
       try {
            $User = Admin::findOrFail($id);
            dd($User);
            return view(Route::currentRouteName(), compact('User'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Admin not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Whoops! something went wrong.');
            return back()->with('flash_error',trans('form.whoops'));
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
       try {
            $User = Admin::findOrFail($id);
            return view(Route::currentRouteName(), compact('User'));
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Admin not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Whoops! something went wrong.');
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
       try {
            $Admin = Admin::findOrFail($id);
            $Update['name'] = $request->name;
            $Update['email'] = $request->email;
            $Update['phone'] = $request->phone;

            if($request->has('password')) {
                $Update['password'] = bcrypt($request->password);
            }
            
            if($request->hasFile('avatar')) {
                $Update['avatar'] = asset('storage/'.$request->avatar->store('admin/profile'));
            }

            $Admin->update($Update);
            // return redirect()->route('admin.Admins.index')->with('flash_success', 'Admin details updated!');
            if(@Auth::user()->hasRole('Admin')){
                return back()->with('flash_success', trans('dispute.admin.updated_success'));
            }else{
                return back()->with('flash_success', trans('dispute.user.updated_success')); 
            }
        } catch (ModelNotFoundException $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Admin not found!');
            return back()->with('flash_error', trans('form.whoops'));
        } catch (Exception $e) {
            // return redirect()->route('admin.Admins.index')->with('flash_error', 'Whoops! something went wrong.');
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
            $Admin = Admin::findOrFail($id);
            $Admin->delete();

            return back()->with('flash_success',trans('dispute.user.removed_success'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
