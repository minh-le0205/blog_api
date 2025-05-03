<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CachableIndex;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Http\Requests\Api\V1\StoreCategoryRequest;
use App\Http\Requests\Api\V1\UpdateCategoryRequest;

class CategoryController extends Controller
{
    use CachableIndex;

    private const CACHE_TRACKER_KEY = 'categories_cache_keys';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = $this->makeIndexCacheKey($request, 'categories_index');

        $raw = Cache::remember($cacheKey, 3600, function () {
            return Category::orderBy('name')->get()->toArray();
        });

        $this->rememberKey(self::CACHE_TRACKER_KEY, $cacheKey);

        $collection = collect($raw)->map(fn ($cat) => (new Category())->forceFill($cat));

        return CategoryResource::collection($collection);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        $this->clearCachedIndexPages(self::CACHE_TRACKER_KEY);
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        $this->clearCachedIndexPages(self::CACHE_TRACKER_KEY);
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        $this->clearCachedIndexPages(self::CACHE_TRACKER_KEY);
        return response()->json(null, 204);
    }
}
