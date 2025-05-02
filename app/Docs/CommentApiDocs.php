<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Comment",
 *     description="API bình luận bài viết"
 * )

 * @OA\Get(
 *     path="/api/v1/posts/{post_id}/comments",
 *     tags={"Comment"},
 *     summary="Lấy danh sách bình luận của bài viết",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="post_id",
 *         in="path",
 *         description="ID bài viết",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Danh sách bình luận"
 *     )
 * )

 * @OA\Post(
 *     path="/api/v1/posts/{post_id}/comments",
 *     tags={"Comment"},
 *     summary="Tạo bình luận mới cho bài viết",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="post_id",
 *         in="path",
 *         description="ID bài viết",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"content"},
 *             @OA\Property(property="content", type="string", example="Bài viết hay quá!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tạo bình luận thành công"
 *     )
 * )
 */
class CommentApiDocs {}