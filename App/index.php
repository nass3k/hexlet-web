<?php

use App\HTML;

require __DIR__ . '/vendor/autoload.php';

$tag = ['name' => 'hr', 'class' => 'px-3', 'id' => 'myid', 'tagType' => 'single'];
$html1 = HTML\stringify($tag);
print_r($html1);
// <hr class="px-3" id="myid">


$tag = ['name' => 'div', 'tagType' => 'pair', 'body' => 'text2', 'id' => 'wow'];
$html = HTML\stringify($tag);
print_r($html);
// <div id="wow">text2</div>
