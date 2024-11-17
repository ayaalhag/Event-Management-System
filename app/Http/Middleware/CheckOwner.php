<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$route)
    {
        if($route=='user'){
        $user=Auth::guard('api')->user();
        $yourProfilId=$request->user_id;
        $yourProfil=User::find($yourProfilId);
        if(!$yourProfil)
        {
            return response()->json(['!$request->user_id']);
        }
        if($yourProfil->id!== $user->id)
        {
            return response()->json(['$yourProfil->id!== $user->id']);
        }
    }
    
    if($route=='event')
    {
        $user=Auth::guard('api')->user();
        $eventId=$request->event_id;
        $event=Event::find($eventId);
        if(!$event)
        {
            return response()->json(['!$event']);
        }
        if($event->user_id !== $user->id)
        {
            return response()->json(['$event->user_id !== $user->id']);
        }
        
    }
   // return response()->json([$user->id]);
   return $next($request);
    }

}
