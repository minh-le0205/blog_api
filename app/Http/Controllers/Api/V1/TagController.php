<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\CachableIndex;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Api\V1\TagResource;
use App\Http\Requests\Api\V1\StoreTagRequest;
use App\Http\Requests\Api\V1\UpdateTagRequest;

class TagController extends Controller
{
    use CachableIndex;

    private const CACHE_TRACKER_KEY = 'tags_cache_keys';

    public function index(Request $request)
    {
        $cacheKey = $this->makeIndexCacheKey($request, 'tags_index');

        $raw = Cache::remember($cacheKey, 3600, function () {
            return Tag::orderBy('name')->get()->toArray();
        });

        $this->rememberKey(self::CACHE_TRACKER_KEY, $cacheKey);

        $collection = collect($raw)->map(fn ($tag) => (new Tag())->forceFill($tag));

        return TagResource::collection($collection);
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
