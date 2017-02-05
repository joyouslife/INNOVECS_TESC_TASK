<?php

class UsersController extends AbstractController
{
    protected $viewFolder = 'users/';

    public function indexAction()
    {
        $vars = array(
            'users' => $this->app->service('user')->getAll()
        );

        echo $this->app->render($this->viewFolder.'index.php', $vars);
    } //end indexAction

    public function addAction()
    {
        $vars = array(
            'roles' => $this->app->service('user')->getRoles()
        );

        echo $this->app->render($this->viewFolder.'add_new_form.php', $vars);
    } // end addAction

    public function editAction()
    {
        $userID = $this->app->router->params[0];
        $userModel = $this->app->service('user')->getModelByID($userID);


        if (!$userModel) {
            throw new NotFoundPageException('Not found user '.$userID);
        }

        $vars = array(
            'roles' => $this->app->service('user')->getRoles(),
            'userModel' => $userModel
        );

        echo $this->app->render($this->viewFolder.'edit_form.php', $vars);
    } // end editAction

    public function addNewAjaxAction()
    {
        try {
            $userModel = $this->app->service('addUser')->start();

            $data = array(
                'status'  => 'success',
                'message' => $this->app->render(
                    $this->viewFolder.'user_created_message.php',
                    array('userModel' => $userModel)
                )
            );
        } catch (AjaxException $e) {
            $data = array(
                'status'  => 'error',
                'message' => $e->getMessage()
            );
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    } // end addNewAjaxAction

    public function editAjaxAction()
    {
        try {
            $this->app->service('editUser')->start();

            $data = array(
                'status'  => 'success',
                'message' => 'Successful update'
            );
        } catch (AjaxException $e) {
            $data = array(
                'status'  => 'error',
                'message' => $e->getMessage()
            );
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    } // end editAjaxAction

    public function deleteAjaxAction()
    {
        try {
            $this->app->service('deleteUser')->start();

            $data = array(
                'status'  => 'success',
                'remove_item' => $_POST['user_id']
            );
        } catch (AjaxException $e) {
            $data = array(
                'status'  => 'error',
                'message' => $e->getMessage()
            );
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    } // end deleteAjaxAction
}