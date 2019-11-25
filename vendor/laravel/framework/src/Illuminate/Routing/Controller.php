<?php

namespace Illuminate\Routing;

use BadMethodCallException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

abstract class Controller
{
    /**
     * The middleware registered on the controller.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Register middleware on the controller.
     *
     * @param  array|string|\Closure  $middleware
     * @param  array   $options
     * @return \Illuminate\Routing\ControllerMiddlewareOptions
     */
    public function middleware($middleware, array $options = [])
    {
        foreach ((array) $middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }

        return new ControllerMiddlewareOptions($options);
    }

    /**
     * Get the middleware assigned to the controller.
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function actionDispatch (Request $request) {
        $funClass = get_called_class();$methd = $request->get('action');
        if (method_exists($funClass,$request->action)){
            return $this->$methd($request);
        } else {
            return false;
        }
    }
    
    /**
     * gain the userInfos
     */
    public function userId () {
        $userKey  = substr((explode('-',Input::header('X-API-TOKEN')))[1],0,-1);
        return strrev(base64_decode($userKey));
    }
}
