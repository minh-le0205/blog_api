<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255', // sometimes : Nếu trường này có trong request thì mới validate (giúp cập nhật từng phần – partial update)
            'body' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'tag_ids' => 'sometimes|array',
            'tag_ids.*' => 'exists:tags,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'body.required' => 'Vui lòng nhập nội dung bài viết.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'tag_ids.*.exists' => 'Một hoặc nhiều tag không hợp lệ.',
        ];
    }
}
