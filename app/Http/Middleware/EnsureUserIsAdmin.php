<?php
namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Verificamos si el usuario está autenticado Y si su rol es 'admin'
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }
    
    // Si no es admin, lo mandamos al menú público
    return redirect('/menu')->with('error', 'Acceso restringido.');
}
}
