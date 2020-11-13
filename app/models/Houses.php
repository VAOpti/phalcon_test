<?php
//
namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Houses extends Model
{
    public $house_id;
    public $street;
    public $number;
    public $addition;
    public $zipCode;
    public $city;

//    public function validation()
//    {
//
//    }
}