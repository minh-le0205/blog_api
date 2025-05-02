<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Category",
 *     description="API quản lý danh mục bài viết"
 * )

 * @OA\Get(
 *     path="/api/v1/categories",
 *     tags={"Category"},
 *     summary="Danh sách danh mục",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Danh sách danh mục"
 *     )
 * )

 * @OA\Post(
 *     path="/api/v1/categories",
 *     tags={"Category"},
 *     summary="Tạo mới danh mục",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Laravel Tips")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tạo danh mục thành công"
 *     )
 * )

 * @OA\Get(
 *     path="/api/v1/categories/{id}",
 *     tags={"Category"},
 *     summary="Chi tiết danh mục",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID danh mục",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Chi tiết danh mục"
 *     )
 * )

 * @OA\Put(
 *     path="/api/v1/categories/{id}",
 *     tags={"Category"},
 *     summary="Cập nhật danh mục",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID danh mục",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Laravel Advanced")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cập nhật thành công"
 *     )
 * )

 * @OA\Delete(
 *     path="/api/v1/categories/{id}",
 *     tags={"Category"},
 *     summary="Xoá danh mục",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID danh mục",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Xoá thành công"
 *     )
 * )
 */
class CategoryApiDocs {}