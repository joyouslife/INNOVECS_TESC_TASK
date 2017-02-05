<?php

abstract class AbstractModel
{
    protected $app;
    protected $viewFolder = '';

    public function __construct(&$app, $data)
    {
        $this->app = $app;
        $this->load($data);
        $this->onInit();
    } // end __construct

    protected function onInit()
    {
    } // end onInit

    public function load($data)
    {
        foreach ($data as $ident => $value) {
            $property = $this->propertiesMap($ident);
            $this->{$property} = $value;
        }
    } // end load

    protected function propertiesMap($ident)
    {
        $map = array();

        if (!array_key_exists($ident, $map)) {
            return $ident;
        }

        return $map[$ident];
    } // end properiesMap
}