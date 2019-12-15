<?php

namespace App\LinkedList;

use App\Node;

function reverse(\App\Node $list)
{
    $newHead = null;
    $current = $list;
    while ($current) {
        $newHead = new Node($current->getValue(), $newHead);
        $current = $current->getNext();
    }

    return $newHead;
}