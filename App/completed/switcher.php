<?php

$address = $_SERVER['REQUEST_URI'];
switch ($address) {
    case '/':
        echo '<a href="/welcome">welcome</a>';
        echo '<br>';
        echo '<a href="/not-found">not-found</a>';
        break;
    case '/welcome':
        echo '<a href="/">main</a>';
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo 'Page not found. <a href="/">main</a>';
        break;
}
