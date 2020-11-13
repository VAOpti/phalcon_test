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

//        echo "<pre>";
//        print_r($sessions);
//        echo "</pre>";

        if ($sessions->has("user_id")) {
            //if user is already logged we dont need to do anything
            // so we redirect them to the main page

            return $this->response->redirect("/");
        }

        $i = 0;
        if ($this->request->isPost()) {
            $password = $this->request->getPost("password");
            $email = $this->request->getPost("email");

            if ($email === "") {
                $this->flashSession->error("return enter your email"  . strval($i++));
                //pick up the same view to display the flash session errors
//                return $this->view->pick("index");
            } else {
                $this->flashSession->success("email is " . $email);
            }

            if ($password === "") {
                echo ("pass err: " . strval($i));
                $this->flashSession->error("return enter your password" . strval($i++));
                //pick up the same view to display the flash session errors
//                return $this->view->pick("index");
            } else {
                $this->flashSession->success("pass is " . $password);
            }

            $user = Users::findFirst([
                "conditions" => "email = ?0 AND password = ?1",
                "bind" == [
                    0 => $email,
//                    1 => $this->security->hash($password)
                    1 => $password
                ]
            ]);

            $this->flashSession->error("asda " . print_r($user));
            $this->flashSession->error("User result: " . print_r($user) . " " . strval($i++));

            if (!$user) {
                echo ("user err: " . strval($i++));
                $this->flashSession->error("wrong user / password");
            } else {
                $this->flashSession->success("Logged in!" . strval($i++));
                $sessions->set("user_id", $user->user_id);
//                return $this->response->redirect("/");
            }
        } else {
            $this->flashSession->error("Got no post");
        }
    }
}