<?php

@require_once 'vendor/autoload.php';

use Imagecow\Image;

function getThumbName($file, $transform) {
    // remove illegal file system characters https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
    $postfix = str_replace(array_merge(
        array_map('chr', range(0, 31)),
        array('<', '>', ':', '"', '/', '\\', '|', '?', '*', '\'')
    ), '-', $transform);
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $name = pathinfo($file, PATHINFO_FILENAME);
    return '___thumb___' . $name . '__' . $postfix . '.' . $ext;
}

// <img src="image.php?file=flower.jpg&amp;transform=resize,1000"/>
$file = __DIR__.'/'.$_GET['file'];
$transform = isset($_GET['transform']) ? $_GET['transform'] : null;
$thumbFile = getThumbName($file, $transform);

if(file_exists($thumbFile)) {
    $image = Image::fromFile('./thumbs/'.$thumbFile);
} else {
    //Create the image instance
    $image = Image::fromFile('./images/'.$file);
    $image->transform($transform);
    $image->save('./thumbs/'.$thumbFile);
}

//Transform the image and display the result:
$image->show();
