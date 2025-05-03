<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\CachableIndex;
use App\Helpers\PostCacheHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Api\V1\PostResource;
use App\Http\Requests\Api\V1\StorePostRequest;
use App\Http\Requests\Api\V1\UpdatePostRequest;

class PostController extends Controller
{
    use CachableIndex;

    const CACHE_TRACKER_KEY = 'posts_index_keys';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = $this->makeIndexCacheKey($request, 'posts_index');

        $paginator = Cache::remember($cacheKey, 600, function () use ($request) {
            return Post::with(['user', 'category', 'tags'])
                ->latest()
                ->filter($request)
                ->paginate(10);
        });

        $this->rememberKey(self::CACHE_TRACKER_KEY, $cacheKey);

        return PostResource::collection($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest  $request)
    {
        // 1. Tạo mảng dữ liệu hợp lệ
        $data = $request->only(['title', 'body', 'category_id']);
        $data['user_id'] = auth()->id() ?? 1;

        // 1.1 Xử lý ảnh thumbnail nếu có
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $data['thumbnail'] = $filename;
        }

        // 2. Tạo bài viết mới
        $post = Post::create($data);

        // 3. Gắn tag cho bài viết nếu có
        if ($request->has('tag_ids')) {
            $post->tags()->attach($request->tag_ids);
        }

        $this->clearCachedIndexPages(self::CACHE_TRACKER_KEY);

        // 4. Load quan hệ và trả về
        return new PostResource($post->load(['user', 'category', 'tags']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // 1. Load các quan hệ liên quan (nếu chưa eager load mặc định)
        $post->load(['user', 'category', 'tags']);

        // 2. Trả về JSON chi tiết bài viết
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        // 1. Chuẩn bị dữ liệu cần cập nhật
        $data = $request->only(['title', 'body', 'category_id']);

        // 1.1 Nếu có file mới, xử lý ảnh
        if ($request->hasFile('thumbnail')) {
            // Xoá ảnh cũ nếu có
            if ($post->thumbnail) {
                Storage::delete('public/posts/' . $post->thumbnail);
            }

            $file = $request->file('thumbnail');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $filename);
            $data['thumbnail'] = $filename;
        }

        // 2. Cập nhật post
        $post->update($data);

        // 3. Đồng bộ tags
        if ($request->has('tag_ids')) {
            $post->tags()->sync($request->tag_ids);
        }

        $this->clearCachedIndexPages(self::CACHE_TRACKER_KEY);
        // 4. Load quan hệ và trả về
        return new PostResource($post->load(['user', 'category', 'tags']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        // 1. Xóa bài viết (nếu dùng soft delete thì sẽ không xóa thật)
        $post->delete();

        $this->clearCachedIndexPages(self::CACHE_TRACKER_KEY);

        // 2. Trả về response JSON rỗng và status 204 (No Content)
        return response()->json(null, 204);
    }
}
