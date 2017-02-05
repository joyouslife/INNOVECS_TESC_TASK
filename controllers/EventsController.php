<?php

class EventsController extends AbstractController
{
    protected $viewFolder = 'events/';

    public function indexAction()
    {
        if (!$this->app->service('access')->canSeeEventsReport()) {
            echo $this->app->render('access_denied.php');
            return false;
        }

        $filterData = $this->app->service('EventsForm')->getFilters();

        $vars = array(
            'reportData' => $this->app->service('events')->getReport($filterData)
        );

        echo $this->app->render($this->viewFolder.'index.php', $vars);
    } //end indexAction
}