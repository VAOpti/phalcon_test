<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {

    }

    public function loginAction()
    {
        $sessions = $this->getDI()->getShared("session");

        if ($sessions->has("user_id")) {
            //if user is already logged we dont need to do anything
            // so we redirect them to the main page

            return $this->response->redirect("/");
        }

        if ($this->request->isPost()) {
            $password = $this->request->getPost("password");
            $email = $this->request->getPost("email");

            //Check if the fields weren't empty
            if ($email === "") {
                $this->flashSession->error("Please enter your email address");
            } else {
                $this->flashSession->success("email is " . $email);
            }

            if ($password === "") {
                $this->flashSession->error("Please enter your password");
            } else {
                $this->flashSession->success("pass is " . $password);
            }

            //TODO: findFirst always returns TRUE so the user can always log in even when they fill in nothing
            $user = Users::findFirst([
                "conditions" => "email = ?0 AND password = ?1",
                "bind" == [
                    0 => $email,
//                    1 => $this->security->hash($password), //Passwords aren't hashed in the db yet
                    1 => $password
                ]
            ]);

            if (!$user) {
                $this->flashSession->error("wrong user / password");
            } else {
                $this->flashSession->success("Logged in!");
                $sessions->set("user_id", $user->user_id);
//                return $this->response->redirect("/");
            }
        } else {
            $this->flashSession->error("Got no post");
        }
    }
}