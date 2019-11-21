<?php

namespace App;

class Validator
{
    public function validate(array $school)
    {
        $errors = [];
        if ($school['name'] == '') {
            $errors['name'] = "Can't be blank";
        }
        return $errors;
    }
}