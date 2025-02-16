<?php
namespace Core;

use App\Controllers\SiteController;
use Core\exception\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false){
            $this->response->setStatusCode(404);
            return throw new NotFoundException();
            /*return $this->renderView("_404");*/
        }

        if(is_string($callback)){
            return Application::$app->view->renderView($callback);
        }

        if(is_array($callback)){
            /** @var Controller $controller */

            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }


        return call_user_func($callback, $this->request, $this->response);

    }

    /*public function renderView($view, $params=[])
    {
       return Application::$app->view->renderView($view, $params);
    }*/

    /*protected function layoutContent()
    {
        $layout = Application::$app->layout;

        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/app/Views/layouts/$layout.php";
        return ob_get_clean();
    }*/

    /*protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/app/Views/$view.php";
        return ob_get_clean();
    }*/
}