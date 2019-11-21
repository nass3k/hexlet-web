<?php

namespace App;

class Validator
{
    public function validate(array $post)
    {
        $errors = [];
        if ($post['name'] == '') {
            $errors['name'] = "Can't be blank";
        }

        if (empty($post['body'])) {
            $errors['body'] = "Can't be blank";
        }

        return $errors;
    }
}
