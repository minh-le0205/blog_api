<?php

namespace App\Helpers;

class PostCacheHelper
{
    const CACHE_KEY_TRACKER = 'posts_index_keys'; // Redis Set

    public static function makeIndexCacheKey($request)
    {
        $page = $request->get('page', 1);
        $filters = [
            'keyword' => $request->get('keyword'),
            'category_id' => $request->get('category_id'),
            'tag_ids' => $request->get('tag_ids'),
        ];

        $hash = md5(json_encode($filters));

        return "posts_index_page_{$page}_{$hash}";
    }

    public static function rememberKey(string $cacheKey)
    {
        \Cache::store('redis')->connection()->sadd(self::CACHE_KEY_TRACKER, $cacheKey);
    }

    public static function clearCachedIndexPages()
    {
        $keys = \Cache::store('redis')->connection()->smembers(self::CACHE_KEY_TRACKER);

        foreach ($keys as $key) {
            \Cache::forget($key);
        }

        // Xoá luôn danh sách để reset lại vòng cache mới
        \Cache::store('redis')->connection()->del(self::CACHE_KEY_TRACKER);
    }
}
