<?php

class LoginController extends AbstractController
{
    protected $viewFolder = 'login/';

    public function indexAction()
    {
        if ($this->app->service('session')->isUserSessionStarted()) {
            echo $this->app->render($this->viewFolder.'complete.php');
        } else {
            echo $this->app->render($this->viewFolder.'form.php');
        }
    } //end indexAction

    public function ajaxAction()
    {
        try {
            $this->app->service('UserLogin')->signIn();

            $data = array(
                'status'  => 'success',
                'message' => 'Success'
            );

            $this->app->service('events')->addLoginSuccess();
        } catch (AjaxException $e) {
            $data = array(
                'status'  => 'error',
                'message' => $e->getMessage()
            );

            $this->app->service('events')->addLoginError();
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    } // end Action

    public function exitAction()
    {
        $this->app->service('session')->removeUserSession();
        header('Location: /');
    } // end exitAction
}