<?php
$devConfig = include(__DIR__.'/dev/config.inc.php');
$prodConfig = include(__DIR__.'/prod/config.inc.php');

if($_ENV['SLIM_MODE'] == 'production') {
    return $prodConfig;
} else {
    return $devConfig;
}
