<?php

namespace App;

class DatabaseConfigLoader
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load($name)
    {
        $filename = "database.{$name}.json";
        $raw = file_get_contents($this->path . '/' . $filename);
        $config = json_decode($raw, true);
        if (!isset($config['extend'])) {
            return $config;
        }
        $newName = $config['extend'];
        unset($config['extend']);
        return array_merge($this->load($newName), $config);
    }
}
