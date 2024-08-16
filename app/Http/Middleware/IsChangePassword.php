<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsChangePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) : Response
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();

        if ($user->isStudent() && auth()->user()->is_change_password == false) {
            return redirect()->route('profile.edit')->with('error', 'Tolong ubah password terlebih dahulu!');
        }

        return $next($request);
    }
}
