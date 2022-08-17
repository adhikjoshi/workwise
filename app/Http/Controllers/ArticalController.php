<?php

namespace App\Http\Controllers;

use App\Models\Artical;
use Illuminate\Support\Facades\Http;
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
        $article = Artical::where('publication_date', '>=', date('Y-m-d H:i:s'))->get();
        //$data =  $this->get_sentiment('Hi, good morning. This is Adhik Joshi');
        foreach ($article as $key => $value) {
            $sentiment =  $this->get_sentiment($value->content);
            $article[$key]->sentiment = $sentiment['result']['type'];
            unset($article[$key]->content);
        }
        //return ArticalResource::collection(Artical::paginate());
        return $article;
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
        return response()->json(['status' => 'success', 'message' => 'Artical Successfully Saved, Artical No.: ' . $data->id . ' ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artical  $artical
     * @return \Illuminate\Http\Response
     */
    public function show(Artical $artical)
    {
        $data = Artical::where('id', $artical->id)->where('publication_date', '>=', date('Y-m-d H:i:s'))->first();
        $sentiment =  $this->get_sentiment($data->content);
        $response = [
            'name' => $data->name,
            'content' => $data->content,
            'author' => $data->author,
            'publication_date' => $data->publication_date,
            'santiment' => $sentiment['result']['type'],
        ];
        // return Artical::where('id', $artical->id)->get();
        return $response;
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
        return response()->json(['status' => 'success', 'message' => 'Artical Updated']);
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
        return response()->json(['status' => 'success', 'message' => 'Artical Deleted']);
    }

    protected function get_sentiment($val)
    {
        $apiURL = 'https://sentim-api.herokuapp.com/api/v1/';
        $postInput = [
            'text' => $val
        ];
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $statusCode = $response->status();
        return json_decode($response->getBody(), true);
    }
}
