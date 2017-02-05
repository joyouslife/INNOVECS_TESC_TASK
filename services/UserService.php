<?php

class UserService extends AbstractService
{
    private $_tableName = 'users';
    private $_roles = array(
        'admin',
        'user'
    );

    public function getModelByLogin($login)
    {
        if (!$login) {
            return false;
        }

        return $this->_getModelByCondition("login = '$login'");
    } // end getByLogin

    public function getModelByID($id)
    {
        if (!$id) {
            return false;
        }

        return $this->_getModelByCondition("id = '$id'");
    } // end getModelByID

    private function _getModelByCondition($condition)
    {
        if (!$condition) {
            return false;
        }

        $sql = "  SELECT * FROM $this->_tableName ";
        $sql .= " WHERE $condition";

        $result = $this->app->db()->query($sql);

        $data = array();

        while ($data[] = $result->fetch_assoc());
        array_pop ($data);

        if (!$data) {
            return false;
        }

        $userModel = $this->app->model('User', $data[0]);

        return $userModel;
    } // end _getModelByCondition

    public function getAll()
    {
        $sql = "SELECT * FROM $this->_tableName";

        $result = $this->app->db()->query($sql);

        $data = array();

        while ($data[] = $result->fetch_assoc());
        array_pop ($data);

        if (!$data) {
            return false;
        }

        return $data;
    } // end getAll

    public function getCurrentUserID()
    {
        $id = $this->app->service('session')->getUserId();

        return ($id) ? $id : null;
    } // end getCurrentUserID

    public function getCurrentUserModel()
    {
        $id = $this->app->service('session')->getUserId();

        if (!$id) {
            return false;
        }

        $sql = "  SELECT * FROM $this->_tableName ";
        $sql .= " WHERE id = '$id'";

        $result = $this->app->db()->query($sql);

        $data = array();

        while ($data[] = $result->fetch_assoc());
        array_pop ($data);

        if (!$data) {
            return false;
        }

        $userModel = $this->app->model('User', $data[0]);

        return $userModel;
    } // end getCurrentUserModel

    public function tableName()
    {
        return $this->_tableName;
    } // end tableName

    public function getRoles()
    {
        return $this->_roles;
    } // end getRoles

    public function addNew($login, $password, $role)
    {
        $ctime = time();
        $cdate = date('Y-m-d', $ctime);
        $password = md5(md5($password));

        $sql =  " INSERT INTO $this->_tableName";
        $sql .= " (login, password, role, cdate, ctime)";
        $sql .= " VALUES ('$login', '$password', '$role', '$cdate', '$ctime')";

        $result = $this->app->db()->query($sql);

        if (!$result) return false;

        return $this->getModelByLogin($login);
    } // end addNew

    public function delete($userID)
    {
        $sql =  " DELETE FROM $this->_tableName WHERE id = '$userID'";

        $result = $this->app->db()->query($sql);

        return $result;
    } // end delete

    public function update($userModel)
    {
        $vars = get_object_vars($userModel);

        $values = array();

        foreach ($vars as $ident => $value) {
            $values[] = " $ident = '$value' ";
        }

        $values = implode($values, ',');

        $sql =  " UPDATE $this->_tableName SET $values  WHERE id = '$userModel->id'";

        $result = $this->app->db()->query($sql);

        return $result;
    } // end update
}