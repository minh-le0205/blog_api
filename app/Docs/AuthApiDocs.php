<?php

namespace App\Docs;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Xác thực người dùng (Sanctum)"
 * )

 * @OA\Post(
 *     path="/api/v1/login",
 *     tags={"Auth"},
 *     summary="Đăng nhập người dùng",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Đăng nhập thành công, trả về token",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="1|abc123xyz456...")
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/v1/me",
 *     tags={"Auth"},
 *     summary="Lấy thông tin người dùng hiện tại",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Thông tin người dùng",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Minh Le"),
 *             @OA\Property(property="email", type="string", example="user@example.com")
 *         )
 *     )
 * )
 */
class AuthApiDocs {}