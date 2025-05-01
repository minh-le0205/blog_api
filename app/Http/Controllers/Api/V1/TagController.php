<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\Api\V1\StoreTagRequest;
use App\Http\Requests\Api\V1\UpdateTagRequest;
use App\Http\Resources\Api\V1\TagResource;

class TagController extends Controller
{
    public function index()
    {
        return TagResource::collection(Tag::latest()->paginate(10));
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->validated());
        return new TagResource($tag);
    }

    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        return new TagResource($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(null, 204);
    }
}
