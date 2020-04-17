<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lang;
class TranslationResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang_path = resource_path('lang');
        $listlang = array_diff(scandir($lang_path), array('..', '.'));
        $listlang_file = array_diff(scandir($lang_path.'/en'), array('..', '.'));
        $data = [];
        if($request->has('lang_name') && $request->has('lang_file_name')){
            $data = Lang::get($request->lang_file_name,[],$request->lang_name);
        }
        return view('admin.translation.index',compact('listlang','listlang_file','data'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if($request->has('lang_code')){
            $src = resource_path('lang/en');
            $dst = resource_path('lang/'.$request->lang_code);
            recurse_copy($src,$dst);
        }elseif($request->has('new_key')){

           $path = resource_path('lang/').$request->lang_name.'/'.$request->lang_file_name.'.php'; 
            @chmod($path,0777);
            if($request->has('par')){
                $par = '.'.$request->par.'.';
            }else{
                $par = '.';
            }
            
            $new = "'".$request->key ."' => '". $request->value."'";
            $contents = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $size = count($contents);
            $contents[$size-2] = '    '.$new.','."\n"; // point it to the second last line and assign
            $temp = implode("\n", $contents);
            if (file_exists($path)) {
                    file_put_contents($path, $temp);
            }
            
        }else{
            $path = resource_path('lang/').$request->lang_name.'/'.$request->lang_file_name.'.php';
            @chmod($path,0777);
            if($request->has('par')){
                $par = '.'.$request->par.'.';
            }else{
                $par = '.';
            }
            

           /* return $old = '"'.$request->key .'" => "'. Lang::get($request->lang_file_name.$par.$request->key,[],$request->lang_name).'"';*/

            $old = "'".$request->key ."' => '". Lang::get($request->lang_file_name.$par.$request->key,[],$request->lang_name)."'";
            $new = "'".$request->key ."' => '". $request->value."'";

                if (file_exists($path)) {
                        file_put_contents($path, str_replace(
                            $old, $new, file_get_contents($path)
                        ));
                }
        }

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
