<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostItResource;
use App\Models\PostIt;
use Illuminate\Http\Request;


class PostItController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $query = PostIt::with('user');

        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        $paginated = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return PostItResource::collection($paginated);
    }

    public function store(Request $request): PostItResource
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'required|in:yellow,blue,green,pink,white',
            'font_family' => 'required|string',
            'font_size'   => 'required|string',
            'size'        => 'required|in:S,M,L',
        ]);

        $postIt = $request->user()->postIts()->create($data);
        event(new \App\Events\PostItCreated($postIt));
        return new PostItResource($postIt->load('user'));
    }

    public function show(PostIt $postIt): PostItResource
    {
        return new PostItResource($postIt->load('user'));
    }

    public function update(Request $request, PostIt $postIt): PostItResource
    {
        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'sometimes|required|in:yellow,blue,green,pink,white',
            'font_family' => 'sometimes|required|string',
            'font_size'   => 'sometimes|required|string',
            'size'        => 'sometimes|required|in:S,M,L',
        ]);

        $postIt->update($data);

        return new PostItResource($postIt->load('user'));
    }

    public function destroy(PostIt $postIt): \Illuminate\Http\Response
    {
        $postIt->delete();

        return response()->noContent();
    }
}
