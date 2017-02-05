<?php

class DeleteUserService extends AbstractService
{
    public function start()
    {
        $userID = $this->_getUserID();

        $result = $this->app->service('User')->delete($userID);

        if (!$result) {
            throw new AjaxException('User cannot delete now. Try later.');
        }
    } // end addNewByRequest

    private function _getUserID()
    {
        if (!array_key_exists('user_id', $_POST)) {
            throw new AjaxException('Undefined User Id');
        }

        $userID = $this->_prepareValue($_POST['user_id']);

        if (!$userID) {
            throw new AjaxException('User ID is Required for delete');
        }

        return $userID;
    } // end _getUserID

    private function _prepareValue($value)
    {
        return preg_replace("/[^0-9]/", '', $value);;
    } // end _prepareValue
}