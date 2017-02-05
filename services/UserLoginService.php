<?php

class UserLoginService extends AbstractService
{
    public function SignIn()
    {
        $login = $this->_getLogin();
        $password = $this->_getPassword();

        $userModel = $this->app->service('User')->getModelByLogin($login);

        if (!$userModel) {
            throw new AjaxException('Incorrect data');
        }

        if (!$this->_isCorrectPassword($password, $userModel)) {
            throw new AjaxException('Incorrect data');
        }

        $this->app->service('session')->startUserSession($userModel->id);
    } // end SignIn

    private function _isCorrectPassword($password, $userModel)
    {
        return md5(md5($password)) == $userModel->password;
    } // end _isCorrectPassword

    private function _getLogin()
    {
        if (!array_key_exists('login', $_POST)) {
           throw new AjaxException('Undefined Login');
        }

        $login = $this->_prepareValue($_POST['login']);

        if (!$login) {
            throw new AjaxException('Login is Required field');
        }

        return $login;
    } // end _getLogin

    private function _getPassword()
    {
        if (!array_key_exists('password', $_POST)) {
            throw new AjaxException('Undefined Password');
        }

        $password = $this->_prepareValue($_POST['password']);

        if (!$password) {
            throw new AjaxException('Password is Required field');
        }

        return $password;
    } // end _getPassword

    private function _prepareValue($value)
    {
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $value = mysqli_escape_string($this->app->db(), $value);

        return $value;
    } // end _prepareValue
}