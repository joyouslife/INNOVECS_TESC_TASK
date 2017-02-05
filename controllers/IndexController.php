<?php

class IndexController extends AbstractController
{
    protected $viewFolder = 'index/';

    public function indexAction()
    {
        echo $this->app->render($this->viewFolder.'index.php');
    } //end indexAction
}