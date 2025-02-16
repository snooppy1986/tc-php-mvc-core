<?php


namespace Core;


use Core\middlewares\BaseMIddleware;

class Controller
{
    public string $layout='main';

    public string $action = '';

    protected array $middlewares = [];

    public function render($view, $params=[])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(BaseMIddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}