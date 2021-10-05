<?php

include './vendor/rakibtg/sleekdb/src/Store.php';
$_ENV['SLIM_MODE'] = 'development';
$_ENV['__ROOT_PATH__'] = __DIR__;

use SleekDB\Store;

class Parser
{
    private $imageStore;

    private static function createStore()
    {
        return new Store("images", __DIR__ . '/data', [
            'auto_cache' => true,
            'timeout' => false
        ]);
    }

    public function __construct()
    {
        $this->imageStore = Parser::createStore();
        if ($this->imageStore->count()) {
            $deleted = $this->imageStore->deleteStore();
            ?>PARSER: deleted store</br><?php
            $this->imageStore = Parser::createStore();
        }
    }

    public function parse()
    {
        $directory = '../images';
        $files = array_diff(scandir($directory), array('..', '.'));
        foreach ($files as $key => $file) {
            $insert = $this->imageStore->insert(['id' => $file, 'src' => '/images/' . $file]);
            ?>PARSER: inserted file <?= json_encode($insert) ?></br><?php
        }
    }
}

$parser = new Parser();
$parser->parse();
