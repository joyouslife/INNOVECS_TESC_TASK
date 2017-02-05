<?php

class RouterService extends AbstractService
{
    public $controller = 'index';
    public $action = 'index';
    public $params = array();
    public $request;

    protected function onInit()
    {
       $this->_onInitRequestData();
    } // end onInit

    private function _onInitRequestData()
    {
        $request = $this->request();

        $data = explode('/', $request);

        $this->controller = array_shift($data);
        $this->_prepareCamelCase($this->controller);

        if (!$data) return false;

        $this->action = array_shift($data);
        $this->_prepareCamelCase($this->action);

        if (!$data) return false;

        $this->params = $data;
    } // end _onInitRequestData

    public function request()
    {
        if ($this->request) {
            return request;
        }

        $request = (array_key_exists('url', $_GET)) ? $_GET['url'] : $this->controller;

        $request = trim($request, '/');

        return $request;
    } // end request

    public function run()
    {
        $controller = $this->app->controller($this->controller);
        $action = $this->action.'Action';

        $method = array(&$controller, $action);

        if (!is_callable($method)) {
            $result = defined('DEV_MODE') && DEV_MODE == true;
            $exceptionClass = ($result) ? 'Exception' : 'NotFoundPageException';
            throw new $exceptionClass('Undefined action '.$action);
        }

        call_user_func_array($method, $this->params);
    } // end run

    private function _prepareCamelCase(&$name)
    {
        $parts = explode('-', $name);

        $i = 0;

        foreach ($parts as $key => $value) {
            if (++$i == 1) {
                continue;
            }

            $parts[$key] = ucfirst($value);
        }

        $name = implode($parts);
    } // end _prepareCamelCase
}