<?php

$tags = [
    'div'   => 1,
    'div'   => 2,
    'div'   => 3,
    'a'     => 4
];

require 'SimpleTag.php';

$tag = new SimpleTag;

$tag->el('div', ['id' => 'header'])
    ->el('div')
    ->in('Halo', 'p > h2')->render();