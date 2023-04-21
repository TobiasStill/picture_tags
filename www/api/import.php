<?php

require_once __DIR__ . '/vendor/autoload.php';
ini_set('memory_limit', '1024M');
set_time_limit(600);
header('Content-Type: text/html; charset=utf-8');
ob_end_flush();
ob_implicit_flush(true);

use Brendt\Image\Config\DefaultConfigurator;
use Brendt\Image\ResponsiveFactory;
use Brendt\Image\ResponsiveImage;
use SleekDB\Store;

class ImageImport
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
        $this->imageStore = ImageImport::createStore();
        $this->config = @include(__DIR__ . '/config/config.php');
    }

    public function importImages()
    {
        $directory = '../images';
        $files = array_diff(scandir($directory), array('..', '.'));
        foreach ($files as $key => $file) {
            $exists = $this->imageStore->findOneBy(["name", "=", $file]) != null;
            if(!$exists) {
                $insert = $this->imageStore->insert(['name' => $file, 'src' => '/' . $file, 'tags' => []]);
                echo("\r\nIMPORT: inserted file" . json_encode($insert, JSON_UNESCAPED_SLASHES ));
            }
        }
    }

    public function generateSrcSets(){
        $images = $this->imageStore->findAll(["name" => "asc"]);
        $factory = new ResponsiveFactory(new DefaultConfigurator([
            'enableCache' => true,
            'publicPath' => $_SERVER['DOCUMENT_ROOT'] . $this->config['thumbDir'],
            'sourcePath' => $_SERVER['DOCUMENT_ROOT'] . $this->config['imageDir'],
        ]));
        foreach ($images as $key => $image){
            //$update = !key_exists('srcSet', $image);
            $update = true;
            if($update){
                $responsiveImage = $factory->create($image['name']);
                $image['src'] = $this->config['thumbUrlPath'].$responsiveImage->src();
                $image['srcSet'] = $this->srcset($responsiveImage);
                echo("\r\nIMPORT: created source-set for " . $image['name']);
                $this->imageStore->update([$image]);
            }
        }
    }

    private function srcset(ResponsiveImage $image) {
        $srcset = [];
        foreach (explode(',', $image->srcset()) as $k => $srcW) {
            $srcset[] = $this->config['thumbUrlPath'].$srcW;
        }

        return implode(',', $srcset);
    }
}

$import = new ImageImport();
$import->importImages();
$import->generateSrcSets();
