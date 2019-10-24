<?php

namespace App\Http\Middleware;

use App\Repositories\ApiResponse;
use App\Services\CrazyTokenService;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckAuth extends Middleware
{
    use ApiResponse;

    private $tokenService;
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */

    protected $except = [
        //
    ];

    public function __construct(Application $app,CrazyTokenService $tokenService)
    {
        parent::__construct($app);
        $this->tokenService = $tokenService;
    }

    public function handle($request, Closure $next)
    {
        $verifyRes = $this->tokenService->setToken($request->header('X-API-TOKEN'))->checkToken();
        if ($verifyRes) {
            $request->headers->set('X-API_TOKEN',$request->header('X-API-TOKEN'));
            return parent::handle($request, $next);
        }
        return $this->failed('token invalid',401);
    }
}