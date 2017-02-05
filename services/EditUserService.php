<?php

class EditUserService extends AbstractService
{
    public function start()
    {
        $id = $this->_getID();
        $login = $this->_getLogin();
        $role = $this->_getRole();
        $password = $this->_getPassword();

        $userModel = $this->app->service('User')->getModelByID($id);

        if ($this->_isLoginBusy($login, $userModel)) {
            throw new AjaxException('User with login '.$login.' already exists');
        }

        $userModel->login = $login;

        if ($role) {
            $userModel->role = $role;
        }

        if ($password) {
            $userModel->password = $password;
        }

        $this->app->service('user')->update($userModel);
    } // end addNewByRequest

    private function _isLoginBusy($login, $userModel)
    {
        $model = $this->app->service('User')->getModelByLogin($login);

        if (!$model) {
            return false;
        }

        return $model->id != $userModel->id;
    } // end _isLoginBusy

    private function _getID()
    {
        if (!array_key_exists('user_id', $_POST)) {
            throw new AjaxException('Undefined user ID');
        }

        $id = $this->_prepareValue($_POST['user_id']);

        if (!$id) {
            throw new AjaxException('Login is Required field');
        }

        return $id;
    } // end _getID

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
    } // end _getLoginFromRequest

    private function _getRole()
    {
        if (!array_key_exists('role', $_POST)) {
            return false;
        }

        $role = $this->_prepareValue($_POST['role']);

        if (!$role) {
            throw new AjaxException('Role is Required field');
        }

        return $role;
    } // end _getRole

    private function _getPassword()
    {
        if (!array_key_exists('password', $_POST)) {
            throw new AjaxException('Undefined Password');
        }

        $password = $this->_prepareValue($_POST['password']);

        if (!$password) {
           return false;
        }

        return md5(md5($password));
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