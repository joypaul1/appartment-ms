<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check() && session('branch_id')) {

            $expiresAt = now()->addMinutes(2); /* keep online for 2 min */
            Cache::put('user-is-online-' . auth('admin')->id(), true, $expiresAt);

            /* last seen */
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['last_seen' => now()]);
            return $next($request);
        }
        // return redirect()->to('admin-login');
        return redirect()->route('backend.login.form');
    }
}
