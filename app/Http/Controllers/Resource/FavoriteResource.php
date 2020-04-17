<?php

namespace App\Http\Controllers\Resource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Favorite;
class FavoriteResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $available = Favorite::avalability('active',$request->user()->id)->where('favorites.user_id',$request->user()->id)->get();
        $un_available = Favorite::avalability('banned')->where('favorites.user_id',$request->user()->id)->get();
        if($request->ajax()){
            return [
            'available' => $available,
            'un_available' => $un_available
            ];
        }else{
            return view('user.shop.favourites',compact('available'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'shop_id' => 'required'
        ]);
        try {
            $Favorite = Favorite::where('user_id',$request->user()->id)->where('shop_id',$request->shop_id)->first();
            if(!$Favorite){
                $Favorite = Favorite::create([
                    'shop_id' => $request->shop_id,  
                    'user_id' => $request->user()->id
                ]);
                return response()->json(['message' => trans('form.favorite.favorite')]);
            }
            return response()->json(['message' => trans('form.already_favorite')]);
        }catch (ModelNotFoundException $e) {
             return response()->json(['error' => trans('form.whoops')]);
        }catch(Exception $e){
             return response()->json(['error' => trans('form.whoops')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        
        try {
            $Favorite = Favorite::where('user_id',$request->user()->id)->where('shop_id',$id)->first();
           
            return $Favorite?:[];
        }catch (ModelNotFoundException $e) {
             return response()->json(['error' => trans('form.whoops')]);
        }catch(Exception $e){
             return response()->json(['error' => trans('form.whoops')]);
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
    public function destroy(Request $request,$id)
    {   
        try{
            $Favorite = Favorite::where('shop_id',$id)->where('user_id',$request->user()->id)->firstOrFail();
            $Favorite->delete();
            return response()->json(['message' => trans('form.favorite.un_favorite')]);;
        }catch (ModelNotFoundException $e) {
             return response()->json(['message' => trans('form.no_data_found')]);
        }catch(Exception $e){
             return response()->json(['error' => trans('form.whoops')]);
        }
    }
}
