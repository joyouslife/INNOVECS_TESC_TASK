<?php

class SessionService extends AbstractService
{
    protected function onInit()
    {
        $this->_start();
    } // end onInit

    private function _start()
    {
        if (session_id() == '') {
            session_start();
        }
    } // end _start

    public function startUserSession($id)
    {
        $_SESSION['user'] = $id;
    } // end startUserSession

    public function isUserSessionStarted()
    {
        return isset($_SESSION['user']);
    } // end isUserSessionStarted

    public function removeUserSession()
    {
        unset($_SESSION['user']);
    } // end removeUserSession

    public function getUserId()
    {
        if (!$this->isUserSessionStarted()) {
            return false;
        }

        return $_SESSION['user'];
    } // end getUserId
}