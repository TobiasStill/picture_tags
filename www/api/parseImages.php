<?php

require_once __DIR__ . '/vendor/autoload.php';

use Brendt\Image\Config\DefaultConfigurator;
use Brendt\Image\Exception\FileNotFoundException;
use Brendt\Image\ResponsiveFactory;
use Brendt\Image\ResponsiveImage;
use SleekDB\Store;
use Symfony\Component\Finder\Finder;

/**
 * Fixed a bug in this unmaintained library
 */
class FixResponsiveFactory extends ResponsiveFactory{

    /**
     * @var bool
     */
    private $rebase;

    private function getImageFile(string $directory, string $path) {
        // This is the bugfix; $path matches wrong files
        $path = "/^".ltrim($path, '/')."/";
        $iterator = Finder::create()->files()->in($directory)->path($path)->getIterator();
        $iterator->rewind();

        $sourceImage = $iterator->current();

        if (!$sourceImage) {
            throw new FileNotFoundException("{$this->sourcePath}/{$path}");
        }

        return $sourceImage;
    }
    /**
     * @param bool $rebase
     *
     * @return ResponsiveFactory
     */
    public function setRebase(bool $rebase) : ResponsiveFactory {
        $this->rebase = $rebase;
        parent::setRebase($rebase);
        return $this;
    }
    /**
     * @param string $src
     *
     * @return ResponsiveImage
     * @throws FileNotFoundException
     */
    public function create($src) {
        $responsiveImage = new ResponsiveImage($src);
        $src = $responsiveImage->src();
        $sourceFilename = $this->rebase ? pathinfo($src, PATHINFO_BASENAME) : $src;
        $sourceFile = $this->getImageFile($this->sourcePath, $sourceFilename);

        $filename = pathinfo($sourceFile->getFilename(), PATHINFO_FILENAME);
        $urlPath = '/' . trim(pathinfo($src, PATHINFO_DIRNAME), '/');

        $responsiveImage->setExtension($sourceFile->getExtension());
        $responsiveImage->setFileName($filename);
        $responsiveImage->setUrlPath($urlPath);

        if ($cachedResponsiveImage = $this->getCachedResponsiveImage($responsiveImage, $sourceFile)) {
            return $cachedResponsiveImage;
        }

        $this->fs->dumpFile("{$this->publicPath}{$src}", $sourceFile->getContents());
        $this->createScaledImages($sourceFile, $responsiveImage);

        return $responsiveImage;
    }
}

class Parser
{
    private $imageStore;
    private static $thumbsDir = '../thumbs';
    private static $imageDir = '../images';

    private static function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!self::deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

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
            $this->imageStore->deleteStore();
            ?>PARSER: deleted store</br><?php
            $this->imageStore = Parser::createStore();
        }
        if (!is_dir($this::$thumbsDir)) {
            mkdir($this::$thumbsDir);
        }
    }

    public function parse()
    {
        $memory_limit = ini_get('memory_limit');
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
        $files = array_diff(scandir($this::$imageDir), array('..', '.'));
        $factory = new FixResponsiveFactory(new DefaultConfigurator([
            'publicPath' => $this::$thumbsDir,
            'sourcePath' => $this::$imageDir,
        ]));
        foreach ($files as $key => $file) {
            $image = $factory->create($file);
            $insert = $this->imageStore->insert(['name' => $file, 'src' => $image->srcset() . $file]);
            ?>PARSER: inserted file <?= json_encode($insert) ?></br><?php
        }
        ini_set('memory_limit', $memory_limit);
        set_time_limit(30);
    }
}

$parser = new Parser();
$parser->parse();
