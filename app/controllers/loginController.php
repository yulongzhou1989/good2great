<?php
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    private function _registerSession($user)
    {
        $this->session->set(
            "User",
            [
                "userid"   => $user->id,
                "username" => $user->username,
            ]
        );
    }

    public function indexAction(){

    }

    /**
     * This action authenticate and logs a user into the application
     */
    public function loginAction()
    {
        if ($this->request->isPost()) {
            // Get the data from the user
            $userName = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            // Find the user in the database
            $user = Users::findFirstById();

            if ($user !== false) {
              if ($this->security->checkHash($password, $user->password)) {
                  // The password is valid
                  $this->_registerSession($user);
                  $this->flash->success(
                      "Welcome " . $user->name
                  );
                  // Forward to the index controller if the user is valid
                  return $this->dispatcher->forward(
                      [
                          "controller" => "index",
                          "action"     => "index",
                      ]
                  );
                }
            }
            $this->view->message = "login error!";
        }
    }
}
