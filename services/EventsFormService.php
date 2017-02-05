<?php

class EventsFormService extends AbstractService
{
    public $model;

    protected function onInit()
    {
        $this->_onInitModel();
    } // end onInit

    private function _onInitModel()
    {
        $data = array(
            'date' => '',
            'user_id' => 'all',
            'type' => 'all',
        );

        if ($this->_hasValuesInRequest()) {
            $data = array(
                'date' => $this->_prepareValue($_GET['date']),
                'user_id' => $this->_prepareValue($_GET['user_id']),
                'type' => $this->_prepareValue($_GET['type']),
            );
        }

        $this->model = $this->app->model('EventsReportForm', $data);
    } // end _onInitModel

    private function _hasValuesInRequest()
    {
        return array_key_exists('date', $_GET)
               && array_key_exists('user_id', $_GET)
               && array_key_exists('type', $_GET);
    } // end _hasValuesInRequest

    public function display()
    {
        $vars = array(
            'users' => $this->app->service('user')->getAll(),
            'types' => $this->app->service('events')->getAllTypes(),
            'model' => $this->model
        );

        echo $this->app->render('events/form.php', $vars);
    } // end display

    public function getDateFilterValue()
    {
        return $this->model->date;
    } // end getDateFilterValue

    public function getUserFilterValue()
    {
        return $this->model->user_id;
    } // end getUserFilterValue

    public function getTypeFilterValue()
    {
        return $this->model->type;
    } // end getTypeFilterValue

    private function _prepareValue($value)
    {
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $value = mysqli_escape_string($this->app->db(), $value);

        return $value;
    } // end _prepareValue

    public function getFilters()
    {
        return get_object_vars($this->model);
    } // end getFilters
}