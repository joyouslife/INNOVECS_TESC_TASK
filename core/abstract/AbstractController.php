<?php

abstract class AbstractController
{
    protected $app;
    protected $viewFolder = '';

    public function __construct(&$app)
    {
        $this->app = $app;
        $this->app->service('events')->addRequest();
        $this->app->service('redirect')->init();

        $this->onInit();
    } // end __construct

    protected function onInit()
    {
    } // end onInit

    public function __destruct()
    {
        $this->app->service('events')->addDocumentReady();
    } // end
}