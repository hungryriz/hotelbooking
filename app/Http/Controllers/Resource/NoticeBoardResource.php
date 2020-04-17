<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NoticeBoard;
use App\Transporter;
use App\Http\Controllers\SendPushNotification;
class NoticeBoardResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $NoticeList = NoticeBoard::with('transporter')->get();
        
        return view('admin.notice.index',compact('NoticeList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Transporters = Transporter::all();
        return view('admin.notice.create', compact('Transporters'));
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
                'transporter_id' => 'required',
                'notice' => 'required',
                'title' => 'required'
            ]);
        try {
            $Notice = NoticeBoard::create([
                'transporter_id' => $request->transporter_id,
                'notice' => $request->notice,
                'title' => $request->title,
                'note' => $request->note,
                ]);
             $push_message = $request->notice;
            (new SendPushNotification)->sendPushToProvider($request->transporter_id,$push_message);
            return back()->with('flash_success', trans('form.resource.created'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('form.not_found'));
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
        $Notice = NoticeBoard::findOrFail($id);
        $Transporters = Transporter::all();
        return view('admin.notice.edit', compact('Notice','Transporters'));
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
                'transporter_id' => 'required',
                'notice' => 'required'
            ]);

        try {
            $Notice = NoticeBoard::findOrFail($id);
            if($request->has('title')) {
                $Update['title'] = $request->title;
            }
            if($request->has('note')) {
                $Update['note'] = $request->note;
            }
            if($request->has('transporter_id')) {
                $Update['transporter_id'] = $request->transporter_id;
            }
            if($request->has('notice')) {
                $Update['notice'] = $request->notice;
            }
            $Notice->update($Update);
            return back()->with('flash_success', trans('form.resource.updated'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Product not found!');
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
            $Notice = NoticeBoard::findOrFail($id);
            // Need to delete variants or have them re-assigned
            $Notice->delete();
            return back()->with('flash_success', trans('form.resource.deleted'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'data not found!');
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
    public function TransporterNotice(Request $request)
    {
         try {
            $Notices = NoticeBoard::where('transporter_id',$request->user()->id)->orderBy('id','DESC')->get();
            return $Notices;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => trans('form.whoops')], 500);  
        } catch (Exception $e) {
            return response()->json(['error' => trans('form.whoops')], 500);  
        }
    }
}
