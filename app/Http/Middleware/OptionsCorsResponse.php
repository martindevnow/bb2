<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * OptionsCorsResponse middleware - add CORS headers if request method OPTIONS
 */
class OptionsCorsResponse
{
    /**
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        /* @var $response Response */
        $response = $next($request);
        if (!$request->isMethod('OPTIONS')) {
            return $response;
        }
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, Application');
//        return $next($request);
        return $response;

        $allow = $response->headers->get('Allow'); // true list of allowed methods
        if (!$allow) {
            return $response;
        }
        $headers = [
            'Access-Control-Allow-Methods' => $allow,
            'Access-Control-Max-Age' => 3600,
            'Access-Control-Allow-Headers' => 'X-Requested-With, Origin, X-Csrftoken, Content-Type, Accept',
        ];
        return $response->withHeaders($headers);
    }
}