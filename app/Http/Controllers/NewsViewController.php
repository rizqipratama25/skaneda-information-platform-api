<?php

namespace App\Http\Controllers;

use App\Models\NewsView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class NewsViewController extends Controller
{
     public function store(Request $request, $newsId)
    {
        $viewerId = $request->cookie('viewer_id');
        if (!$viewerId) {
            $viewerId = (string) Str::uuid();
            Cookie::queue('viewer_id', $viewerId, 60 * 24 * 730);
        }

        $fallback = substr(hash('sha256', $request->ip().'|'.$request->userAgent()), 0, 24);

        $who = $viewerId ?: "ipua:$fallback";

        $ttlMinutes = 30;
        $cacheKey   = "viewed:news:$newsId:$who";

        $shouldCount = Cache::add($cacheKey, true, now()->addMinutes($ttlMinutes));

        $row = NewsView::firstOrCreate(['news_id' => $newsId], ['viewers' => 0]);

        if ($shouldCount) {
            $row->increment('viewers');
            $row->refresh();
        }

        return response()->json([
            'news_id'      => (int) $newsId,
            'viewers'      => $row->viewers,
            'counted'      => (bool) $shouldCount,
            'ttl_minutes'  => $ttlMinutes,
            'has_cookie'   => (bool) $request->cookie('viewer_id'),
        ]);
    }
}
