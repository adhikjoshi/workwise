<?php

namespace App\Http\Controllers;

use App\Models\Artical;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\ArticalResource;
use App\Http\Requests\StoreArticalRequest;
use App\Http\Requests\UpdateArticalRequest;
use Illuminate\Http\Client\Request;

class ArticalController extends Controller
{

    // get list of article along with filters
    public function index()
    {
        $tags = request()->query('tags');
        $author = request()->query('author');
        $filter_both = request()->query('filter_both');
        $article = Artical::where('publication_date', '>=', date('Y-m-d H:i:s'));
        if ($filter_both == 1) {
            $article->whereRaw("find_in_set('" . $tags . "' , tags)")->where('author', 'like', '%' . $author . '%');
        } else {
            if (isset($tags)) {
                $article->whereRaw("find_in_set('" . $tags . "' , tags)");
            } elseif (isset($author)) {
                $article->where('author', 'like', '%' . $author . '%');
            }
        }
        $response = $article->get();
        //$article = Artical::where('publication_date', '>=', date('Y-m-d H:i:s'))->get();
        //$data =  $this->get_sentiment('Hi, good morning. This is Adhik Joshi');
        foreach ($response as $key => $value) {
            $sentiment =  $this->get_sentiment($value->content);
            $response[$key]->sentiment = $sentiment['result']['type'];
            unset($response[$key]->content);
        }
        //return ArticalResource::collection(Artical::paginate());
        return $response;
    }

    // Store Articles
    public function store(StoreArticalRequest $request)
    {
        $data = new Artical();
        $data->name = $request->name;
        $data->author = $request->author;
        $data->content = $request->content;
        $data->tags = $request->tags;
        $data->publication_date = $request->publication_date;
        $data->save();
        $data->id;
        return response()->json(['status' => 'success', 'message' => 'Artical Successfully Saved, Artical No.: ' . $data->id . ' ']);
    }

    // Show individual articles
    public function show(Artical $artical)
    {
        $data = Artical::where('id', $artical->id)->where('publication_date', '>=', date('Y-m-d H:i:s'))->first();
        $sentiment =  $this->get_sentiment($data->content);
        $response = [
            'name' => $data->name,
            'content' => $data->content,
            'author' => $data->author,
            'tags' => $data->tags,
            'publication_date' => $data->publication_date,
            'santiment' => $sentiment['result']['type'],
        ];
        // return Artical::where('id', $artical->id)->get();
        return $response;
    }

    // Update articles
    public function update(UpdateArticalRequest $request, Artical $artical)
    {
        $artical->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Artical Updated']);
    }

    // Delete article
    public function destroy(Artical $artical)
    {
        $artical->delete();
        return response()->json(['status' => 'success', 'message' => 'Artical Deleted']);
    }

    // Get sentiment of specific article content
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
