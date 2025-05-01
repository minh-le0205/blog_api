<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PostResource;
use App\Http\Requests\Api\V1\StorePostRequest;
use App\Http\Requests\Api\V1\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Lấy danh sách bài viết mới nhất, có phân trang, và load quan hệ
        $posts = Post::with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(10); // 10 bài viết mỗi trang

        // 2. Trả về danh sách bằng Resource collection
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest  $request)
    {
        // 1. Tạo bài viết mới từ dữ liệu hợp lệ
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'user_id' => auth()->id() ?? 1, // fallback cho trường hợp chưa áp dụng auth
        ]);

        // 2. Gắn tag cho bài viết nếu có
        if ($request->has('tag_ids')) {
            $post->tags()->attach($request->tag_ids);
        }

        // 3. Load các quan hệ liên quan để trả JSON
        $post->load(['user', 'category', 'tags']);

        // 4. Trả về JSON bằng PostResource
        return new PostResource($post);
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
        // 1. Cập nhật các trường chính (nếu có trong request)
        $post->update($request->only(['title', 'body', 'category_id']));

        // 2. Đồng bộ lại tags nếu có tag_ids trong request
        if ($request->has('tag_ids')) {
            $post->tags()->sync($request->tag_ids); // thay thế toàn bộ tags cũ
        }

        // 3. Load lại các quan hệ
        $post->load(['user', 'category', 'tags']);

        // 4. Trả về dữ liệu đã cập nhật
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        // 1. Xóa bài viết (nếu dùng soft delete thì sẽ không xóa thật)
        $post->delete();

        // 2. Trả về response JSON rỗng và status 204 (No Content)
        return response()->json(null, 204);
    }
}
