<?php

class RedirectService extends AbstractService
{
    public function init()
    {
        if ($this->app->service('session')->isUserSessionStarted()) {
            return false;
        }

        if ($this->app->router->controller == 'login') {
            return false;
        }

        $this->go('/login/');
    } // end loginPage

    public function go($url)
    {
        header('Location: '.$url);
        exit();
    } // end go
}