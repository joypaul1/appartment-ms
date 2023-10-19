<?php

namespace App\Http\Middleware;

use App\Models\Backend\BuildingInformation;
use Closure;
use Illuminate\Http\Request;

class CheckBuilding
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
        if(BuildingInformation::first()){
            return $next($request);
        }else{
            return redirect()->route('backend.site-config.building.create')->with('error','Please Create a new Building Information');
        }


    }
}
