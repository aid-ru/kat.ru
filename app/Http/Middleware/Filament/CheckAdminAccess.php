<?php

namespace App\Http\Middleware\Filament;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            // If not authenticated, redirect to Breeze login
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user is admin (id === 1 or role === 'admin')
        if (!$user->isAdmin()) {
            abort(403, 'Access denied. You do not have admin privileges.');
        }

        return $next($request);
    }
}