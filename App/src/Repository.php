<?php

namespace App;

class Repository
{
    private $posts;
    public function __construct()
    {
        $this->posts = Generator::generate(100);
    }

    public function all()
    {
        return $this->posts;
    }

    public function find(string $id)
    {
        return collect($this->posts)->firstWhere('id', $id);
    }
}
