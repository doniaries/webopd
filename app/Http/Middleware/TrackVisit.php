<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only track normal web requests (skip console, ajax assets, etc.)
        if ($request->isMethod('get') && !$request->ajax()) {
            $sessionId = $request->session()->getId();
            $ip = $request->ip();
            $ua = substr((string) $request->userAgent(), 0, 1000);
            $now = now();

            // Log one record per session; update last_activity continuously
            $visit = Visit::query()->where('session_id', $sessionId)->latest('visited_at')->first();

            if (!$visit) {
                Visit::create([
                    'ip' => $ip,
                    'session_id' => $sessionId,
                    'user_agent' => $ua,
                    'visited_at' => $now,
                    'last_activity' => $now,
                    'url' => substr($request->fullUrl(), 0, 512),
                ]);
            } else {
                // Update last activity and url (most recent)
                $visit->update([
                    'last_activity' => $now,
                    'url' => substr($request->fullUrl(), 0, 512),
                ]);
            }
        }

        return $next($request);
    }
}
