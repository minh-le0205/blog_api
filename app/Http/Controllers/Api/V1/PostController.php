<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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

        // 2. Trả về response JSON rỗng và status 204 (No Content)
        return response()->json(null, 204);
    }
}
