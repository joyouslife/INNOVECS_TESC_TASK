<?php

class EventsService extends AbstractService
{
    private $_tableName = 'events';

    private $_types = array(
        'document_ready' => 'document_ready',
        'request' => 'request',
        'login_error' => 'login_error',
        'login_ok' => 'login_ok'
    );

    public function addRequest()
    {
        $type = $this->_types['request'];
        $userID = $this->app->service('user')->getCurrentUserID();

        $this->_insertNewEvent($userID, $type);
    } // end addRequest

    public function addDocumentReady()
    {
        $type = $this->_types['document_ready'];
        $userID = $this->app->service('user')->getCurrentUserID();

        $this->_insertNewEvent($userID, $type);
    } // end addDocumentReady

    public function addLoginError()
    {
        $type = $this->_types['login_error'];

        $this->_insertNewEvent(null, $type);
    } // end addLoginError

    public function addLoginSuccess()
    {
        $type = $this->_types['login_ok'];
        $userID = $this->app->service('user')->getCurrentUserID();

        $this->_insertNewEvent($userID, $type);
    } // end addLoginSuccess

    private function _insertNewEvent(
        $userID, $type
    )
    {
        $ctime = time();
        $cdate = date('Y-m-d', $ctime);
        $request = $this->app->router->request();

        $sql =  " INSERT INTO $this->_tableName";
        $sql .= " (id_user, type, request, cdate, ctime)";
        $sql .= " VALUES ('$userID', '$type', '$request', '$cdate', '$ctime')";

        return $this->app->db()->query($sql);
    } // end _insertNewTransaction

    public function getReport($filtersData = array())
    {
        $usersTableName = $this->app->service('user')->tableName();

        $sql =  " SELECT %eventsTable%.id, %eventsTable%.id_user, %usersTable%.login, %eventsTable%.type, ";
        $sql .= " %eventsTable%.request, %eventsTable%.cdate, %eventsTable%.ctime ";
        $sql .= " FROM %eventsTable% LEFT JOIN users on %eventsTable%.id_user = %usersTable%.id ";

        if ($filtersData) {
            $sql .= $this->_getSqlConditionsByFilters($filtersData);
        }

        $sql = str_replace('%eventsTable%', $this->_tableName, $sql);
        $sql = str_replace('%usersTable%', $usersTableName, $sql);

        $result = $this->app->db()->query($sql);

        $data = array();

        while ($data[] = $result->fetch_assoc());
        array_pop ($data);

        return $data;
    } // end getReport

    private function _getSqlConditionsByFilters($filtersData)
    {
        $sql = "";
        $date = $filtersData['date'];
        $userID = $filtersData['user_id'];
        $type = $filtersData['type'];

        $where = array();

        if ($date) {
            $time = strtotime($date);
            $date = date('Y-m-d', $time);
            $where[] = "%eventsTable%.cdate = '$date'";
        }

        if ($userID != 'all') {
            $where[] = "%eventsTable%.id_user = '$userID'";
        }

        if ($type != 'all') {
            $where[] = "%eventsTable%.type = '$type'";
        }

        if ($where) {
            $sql = " WHERE ".implode($where, ' AND ');
        }

        return $sql;
    } // end _getAllRows

    public function getAllTypes()
    {
        $sql =  " SELECT DISTINCT type FROM $this->_tableName;";

        $result = $this->app->db()->query($sql);

        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row['type'];
        }

        return $data;
    } // end getAllTypes
}