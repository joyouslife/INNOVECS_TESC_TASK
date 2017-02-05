<?php

class AccessService extends AbstractService
{
    private $_adminRole = 'admin';

    public function canModifyuser()
    {
        $currentUser = $this->app->service('user')->getCurrentUserModel();

        if (!$currentUser) {
            return false;
        }

        if ($currentUser->role != $this->_adminRole) {
            return false;
        }

        return true;
    } // end canModifyuser

    public function canDeleteUser($userID)
    {
        $currentUser = $this->app->service('user')->getCurrentUserModel();

        if (!$currentUser) {
            return false;
        }

        //cannot delete self
        if ($currentUser->id == $userID) {
            return false;
        }

        if ($currentUser->role != $this->_adminRole) {
            return false;
        }

        return true;
    } // end canDeleteUser

    public function canAddUser()
    {
        $currentUser = $this->app->service('user')->getCurrentUserModel();

        if (!$currentUser) {
            return false;
        }

        if ($currentUser->role != $this->_adminRole) {
            return false;
        }

        return true;
    } // end canAddUser

    public function canModifyUserRole($userID)
    {
        $currentUser = $this->app->service('user')->getCurrentUserModel();

        if (!$currentUser) {
            return false;
        }

        //cannot edit role
        if ($currentUser->id == $userID) {
            return false;
        }

        if ($currentUser->role != $this->_adminRole) {
            return false;
        }

        return true;
    } // end canModifyUserRole

    public function canSeeEventsReport()
    {
        $currentUser = $this->app->service('user')->getCurrentUserModel();

        if (!$currentUser) {
            return false;
        }

        if ($currentUser->role != $this->_adminRole) {
            return false;
        }

        return true;
    } // end canSeeEventsReport
}