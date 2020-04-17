<?php

namespace App\Http\Controllers\Resource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailTemplate;
use Route;
use Exception;

class EmailTemplateResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $EmailTemplates = EmailTemplate::all();
            return view(Route::currentRouteName(), compact('EmailTemplates'));
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
            'template_name' => 'required|string|max:255|unique:email_templates',
            'email_subject' => 'required',
            'sender_name' => 'required',
            'sender_email' => 'required',
            'content' => 'required'
        ]);

        try {
            $EmailTemplate = $request->all();
            $EmailTemplate = EmailTemplate::create($EmailTemplate);
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
            $EmailTemplate = EmailTemplate::findOrFail($id);

            return view(Route::currentRouteName(), compact('EmailTemplate'));
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
            'template_name' => 'required|string|max:255',
            'email_subject' => 'required',
            'sender_name' => 'required',
            'sender_email' => 'required',
            'content' => 'required'
            ]);

        try {
            $EmailTemplate = EmailTemplate::findOrFail($id);
            $Update = $request->all();
            $EmailTemplate->update($Update);
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
            $EmailTemplate = EmailTemplate::findOrFail($id);
            // Need to delete variants or have them re-assigned
            $EmailTemplate->delete();
            return back()->with('flash_success', trans('form.resource.deleted'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
        } catch (Exception $e) {
            return back()->with('flash_error', trans('form.whoops'));
        }
    }
}
