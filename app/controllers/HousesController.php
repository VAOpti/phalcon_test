<?php

use Phalcon\Mvc\Controller;

class HousesController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        if ($this->request->isPost()) {

            $postData = $this->request->getPost();

            //Send the curl request
            $ch = curl_init('http://localhost/api.phalcon_test/houses');
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($postData)
            ));

            $response = curl_exec($ch);

            // Check for errors
            if($response === FALSE){
                echo "NO RESPONSE";
                die(curl_error($ch));
            }

            //TODO: getting unchaught error: Access to undeclared static property: Phalcon\Di::$_default
            print_r("Response: ". $response);
            // Decode the response
            $responseData = json_decode($response, TRUE);
        }
    }
}