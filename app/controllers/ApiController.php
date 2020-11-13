<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Http\Response;

class ApiController extends Controller
{
    public function housesAction()
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'MyApp\Models' => '../app/models/',
            ]
        );
        $loader->register();

        $container = new FactoryDefault();
        $container->set(
            'db',
            function () {
                return new PdoMysql(
                    [
                        'host' => 'localhost',
                        'username' => 'root',
                        'password' => '',
                        'dbname' => 'house_lister',
                    ]
                );
            }
        );

        $app = new Micro($container);

        // Retrieves all houses
        $app->get(
            '/phalcon_test/api/houses',
            function () use ($app) {
                echo "asd";
                $phql = 'SELECT * '
                    . 'FROM MyApp\Models\Houses';

                $houses = $app
                    ->modelsManager
                    ->executeQuery($phql);

                $data = [];
                foreach ($houses as $house) {
                    $data[] = [
                        'house_id' => $house->house_id,
                        'street' => $house->street,
                        'number' => $house->number,
                        'addition' => $house->addition,
                        'zipCode' => $house->zipCode,
                        'city' => $house->city,
                    ];
                }

                echo json_encode($data);
            }
        );

        // Retrieves robots based on primary key
        $app->get(
            '/phalcon_test/api/houses/{house_id:[0-9]+}',
            function ($id) use ($app) {
                $phql = 'SELECT * '
                    . 'FROM MyApp\Models\Houses '
                    . 'WHERE house_id = :house_id:';

                $house = $app
                    ->modelsManager
                    ->executeQuery(
                        $phql,
                        [
                            'house_id' => $id,
                        ]
                    )
                    ->getFirst();

                $response = new Response();
                if ($house === false) {
                    $response->setJsonContent(
                        [
                            'status' => 'NOT-FOUND'
                        ]
                    );
                } else {
                    $response->setJsonContent(
                        [
                            'status' => 'FOUND',
                            'data' => [
                                'house_id' => $house->house_id,
                                'street' => $house->street,
                                'number' => $house->number,
                                'addition' => $house->addition,
                                'zipCode' => $house->zipCode,
                                'city' => $house->city
                            ]
                        ]
                    );
                }
                echo "<pre>";
                print_r($response);
                echo "</pre>";
            }
        );

        // Adds a new robot
        $app->post(
            '/phalcon_test/api/houses',
            function () use ($app) {
                $house = $app->request->getJsonRawBody();
                $phql = 'INSERT INTO MyApp\Models\Houses '
                    . '(street, number, addition, zipCode, city) '
                    . 'VALUES '
                    . '(:street:, :number:, :addition:, :zipCode:, :city:)';

                $status = $app
                    ->modelsManager
                    ->executeQuery(
                        $phql,
                        [
                            'street' => $house->street,
                            'number' => $house->number,
                            'addition' => $house->addition,
                            'zipCode' => $house->zipCode,
                            'city' => $house->city,
                        ]
                    );

                $response = new Response();

                if ($status->success() === true) {
                    $response->setStatusCode(201, 'Created');

                    $house->house_id = $status->getModel()->house_id;

                    $response->setJsonContent(
                        [
                            'status' => 'OK'
                        ]
                    );
                } else {
                    $response->setStatusCode(409, 'Conflict');

                    $errors = [];
                    foreach ($status->getMessages() as $message) {
                        $errors[] = $message->getMessage();
                    }

                    $response->setJsonContent(
                        [
                            'status' => 'ERROR',
                            'messages' => $errors,
                        ]
                    );
                }

                return $response;
            }
        );

        $app->handle(
            $_SERVER["REQUEST_URI"]
        );
    }
}