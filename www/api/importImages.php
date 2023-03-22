<?php

require_once __DIR__ . '/vendor/autoload.php';

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
    }

    public function parse()
    {
        $directory = '../images';
        $files = array_diff(scandir($directory), array('..', '.'));
        foreach ($files as $key => $file) {
            $exists = $this->imageStore->findOneBy(["name", "=", $file]) != null;
            if(!$exists) {
                $insert = $this->imageStore->insert(['name' => $file, 'src' => '/images/' . $file, 'tags' => []]);
                ?>PARSER: inserted file <?= json_encode($insert) ?></br><?php
            }
        }
    }
}

$parser = new Parser();
$parser->parse();
