<?php

$links = [
    ['url' => 'https://google.com', 'name' => 'Google'],
    ['url' => 'https://yandex.com', 'name' => 'Yandex'],
    ['url' => 'https://bingo.com', 'name' => 'Bingo']
];

foreach ($links as $link) {
    echo "<div>";
    echo "<a href=" . $link['url'] . ">" . $link['name'] . "</a>";
    echo "</div>";
}
