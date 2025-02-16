<?php


namespace Core\middlewares;


use Core\Application;
use Core\exception\ForbiddentException;

class AuthMiddleware extends BaseMIddleware
{
    public array $actions = [];

    /**
     * AuthMiddleware constructor.
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {

        if(Application::isGuest()){
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)){
                return throw new ForbiddentException();
            }
        }
    }
}