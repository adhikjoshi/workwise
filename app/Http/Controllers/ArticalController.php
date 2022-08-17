<?php

namespace App\Http\Controllers;

use App\Models\Artical;
use App\Http\Resources\ArticalResource;
use App\Http\Requests\StoreArticalRequest;
use App\Http\Requests\UpdateArticalRequest;

class ArticalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ArticalResource::collection(Artical::paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticalRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticalRequest $request)
    {
        $data = new Artical();
        $data->name = $request->name;
        $data->author = $request->author;
        $data->content = $request->content;
        $data->publication_date = $request->publication_date;
        $data->save();
        $data->id;
        return response()->json(['status'=>'success','message'=>'Artical Successfully Saved, Artical No.: '.$data->id.' ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function show(Artical $artical)
    {
        return Artical::where('id', $artical->id)->get();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticalRequest  $request
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticalRequest $request, Artical $artical)
    {
        $artical->update($request->all());
        return response()->json(['status'=>'success','message'=>'Artical Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artical $artical)
    {
        $artical->delete();
        return response()->json(['status'=>'success','message'=>'Artical Deleted']);
    }
}
