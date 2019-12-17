<?php

namespace App\HTML;

use Illuminate\Support\Collection;


function buildAttrs(array $tag)
{
    return collect($tag)
        ->except(['name', 'tagType', 'body'])
        ->map(function ($value, $key) {
            return " {$key}=\"{$value}\"";
        })->join('');
}

function stringify($tag)
{
    $mapping = [
        'single' => function ($tag) {
            $attrs = buildAttrs($tag);
            return "<{$tag['name']}{$attrs}>";
        },
        'pair' => function ($tag) {
            $attrs = buildAttrs($tag);
            return "<{$tag['name']}{$attrs}>{$tag['body']}</{$tag['name']}>";
        }
    ];

    $build = $mapping[$tag['tagType']];
    return $build($tag);
}
