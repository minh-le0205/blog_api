<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CachableIndex
{
    protected function makeIndexCacheKey($request, string $prefix = 'index')
    {
        $page = $request->get('page', 1);
        $filters = [
            'keyword' => $request->get('keyword'),
            'category_id' => $request->get('category_id'),
            'tag_ids' => $request->get('tag_ids'),
        ];

        $hash = md5(json_encode($filters));
        return "{$prefix}_page_{$page}_{$hash}";
    }

    protected function rememberKey(string $trackerKey, string $cacheKey)
    {
        Cache::store('redis')->connection()->sadd($trackerKey, $cacheKey);
    }

    protected function clearCachedIndexPages(string $trackerKey)
    {
        $redis = Cache::store('redis')->connection();
        $keys = $redis->smembers($trackerKey);

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        $redis->del($trackerKey);
    }
}
