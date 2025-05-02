<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Post",
 *     description="API quản lý bài viết"
 * )

 * @OA\Post(
 *     path="/api/v1/posts",
 *     tags={"Post"},
 *     summary="Tạo mới một bài viết",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"title", "body", "category_id"},
 *                 @OA\Property(property="title", type="string", example="Tiêu đề bài viết"),
 *                 @OA\Property(property="body", type="string", example="Nội dung bài viết"),
 *                 @OA\Property(property="category_id", type="integer", example=1),
 *                 @OA\Property(property="tag_ids[]", type="array", @OA\Items(type="integer")),
 *                 @OA\Property(property="thumbnail", type="file")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tạo bài viết thành công"
 *     )
 * )

 * @OA\Get(
 *     path="/api/v1/posts",
 *     tags={"Post"},
 *     summary="Danh sách bài viết (có tìm kiếm và lọc)",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="keyword",
 *         in="query",
 *         description="Tìm kiếm tiêu đề",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="category_id",
 *         in="query",
 *         description="Lọc theo danh mục",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="tag_ids[]",
 *         in="query",
 *         description="Lọc theo nhiều tag",
 *         required=false,
 *         @OA\Schema(type="array", @OA\Items(type="integer"))
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Danh sách bài viết"
 *     )
 * )

 * @OA\Get(
 *     path="/api/v1/posts/{id}",
 *     tags={"Post"},
 *     summary="Chi tiết bài viết",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID bài viết",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Chi tiết bài viết"
 *     )
 * )

 * @OA\Put(
 *     path="/api/v1/posts/{id}",
 *     tags={"Post"},
 *     summary="Cập nhật bài viết",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID bài viết",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="title", type="string"),
 *                 @OA\Property(property="body", type="string"),
 *                 @OA\Property(property="category_id", type="integer"),
 *                 @OA\Property(property="tag_ids[]", type="array", @OA\Items(type="integer")),
 *                 @OA\Property(property="thumbnail", type="file")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cập nhật thành công"
 *     )
 * )

 * @OA\Delete(
 *     path="/api/v1/posts/{id}",
 *     tags={"Post"},
 *     summary="Xoá bài viết",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID bài viết",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Xoá thành công"
 *     )
 * )
 */
class PostApiDocs {}