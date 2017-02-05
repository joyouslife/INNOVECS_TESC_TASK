<?php

class App {
    private $_config;
    private $_db;
    private $_mainFile;
    public $router;
    protected $app;

    public function __construct($config, $notFoundPage = false)
    {
        $this->app = &$this;
        $this->_config = $config;

        if ($notFoundPage) {
            echo $this->render('404.php');
            return false;
        }

        $this->_onInitDbConnection();
        $this->router = $this->service('router');
        $this->router->run();
    } // end __construct

    public function controller($name)
    {
        $name = ucfirst($name).'Controller';

        return new $name($this);
    } // end controller

    public function model($name, $params = array())
    {
        $name = ucfirst($name).'Model';

        return new $name($this, $params);
    } // end model

    public function service($name)
    {
        $name = ucfirst($name).'Service';

        return new $name($this);
    } // end service

    public function render($template, $vars = array())
    {
        if ($vars) {
            extract($vars);
        }

        $templateFile = $this->getTemplatePath($template);

        ob_start();

        include $templateFile;

        $content = ob_get_clean();

        return $content;
    } // end render

    public function displayHeader()
    {
        $vars = array(
            'isUserLoged' => $this->service('session')->isUserSessionStarted()
        );

        echo $this->render('layouts/header.php', $vars);
    } // end displayHeader

    public function displayFooter()
    {
        echo $this->render('layouts/footer.php');
    } // end displayFooter

    public function getTemplatePath($template = '')
    {
        return $this->config('main_path').'views/'.$template;
    } // end getTemplatePath

    public function config($key)
    {
        if (!array_key_exists($key, $this->_config)) {
            throw new Exception('Not found key'.$key.' in config array.');
        }

        return $this->_config[$key];
    } // end config

    public function db()
    {
        return $this->_db;
    } // end db

    private function _onInitDbConnection()
    {
        $this->_db = mysqli_connect(
            $this->config('db_host'),
            $this->config('db_user'),
            $this->config('db_pass'),
            $this->config('db_name')
        );

        if ($this->_db) {
           return true;
        }

        throw new Exception('Mysql Error Connection');
    } //end _onInitDbConnection

    private function _onCloseDbConnection()
    {
        if (!$this->_db) {
            return false;
        }

        mysqli_close($this->_db);
    } // end _onCloseDbConnection

    public function __destruct()
    {
        $this->_onCloseDbConnection();
    } // end __destruct
}