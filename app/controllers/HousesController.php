<?php

use Phalcon\Mvc\Controller;

class HousesController extends Controller
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $house = new \MyApp\Models\Houses();

        if ($this->request->isPost()) {
            $house->assign(
                $this->request->getPost(),
                [
                    'street',
                    'number',
                    'addition',
                    'zipCode',
                    'city'
                ]
            );

            $postData = $this->request->getPost();

            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/json",
                    'content' => json_encode($postData)
                )
            ));

            $response = file_get_contents('http://localhost/phalcon_test/api/houses/', FALSE, $context);

            // Check for errors
            if($response === FALSE){
                echo "DIED";
                //die('Error');
            }

            // Decode the response
            $responseData = json_decode($response, TRUE);

            // Print the date from the response
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        }
    }
}