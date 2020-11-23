<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class Users extends Model
{
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $admin;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new Uniqueness(
                [
                    'message' => 'The user email already exists',
                ]
            )
        );

        if ($this->admin == "on") {
            $this->admin = TRUE;
        } else {
            $this->admin = FALSE;
        }

        return $this->validate($validator);
    }
}