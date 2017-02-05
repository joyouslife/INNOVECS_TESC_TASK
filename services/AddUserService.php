<?php

class AddUserService extends AbstractService
{
    public function start()
    {
        $login = $this->_getLogin();
        $role = $this->_getRole();

        $userModel = $this->app->service('User')->getModelByLogin($login);

        if ($userModel) {
            throw new AjaxException('User with login '.$login.' already exists');
        }

        $password = $this->_generatePassword($login, $role);

        $userModel = $this->app->service('user')->addNew(
            $login,
            $password,
            $role
        );

        $userModel->password = $password;

        return $userModel;
    } // end addNewByRequest

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
            throw new AjaxException('Undefined Role');
        }

        $role = $this->_prepareValue($_POST['role']);

        if (!$role) {
            throw new AjaxException('Role is Required field');
        }

        return $role;
    } // end _getRole

    private function _prepareValue($value)
    {
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $value = mysqli_escape_string($this->app->db(), $value);

        return $value;
    } // end _prepareValue

    private function _generatePassword($login, $role)
    {
        return mb_substr(md5($role.time().$login), 0, 6);
    } // end _generatePassword
}