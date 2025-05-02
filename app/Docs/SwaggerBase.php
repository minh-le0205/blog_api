<?php

namespace App\Docs;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Blog API Documentation",
 *         description="Tài liệu RESTful API cho dự án Blog (Laravel + Sanctum)",
 *         @OA\Contact(
 *             email="minh.levunguyen@gmail.com",
 *             name="Minh Le"
 *         )
 *     ),

 *     @OA\Server(
 *         url="{{local_domain}}",
 *         description="Local Development"
 *     ),

 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT"
 *         )
 *     )
 * )
 */
class SwaggerBase
{
}
