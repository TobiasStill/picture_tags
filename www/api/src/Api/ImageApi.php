<?php

namespace OpenAPIServer\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SleekDB\Store;
use Slim\Exception\HttpNotImplementedException;

class ImageApi extends AbstractImageApi
{
    private mixed $config;

    private static function idCompare($img1, $img2)
    {
        if ($img1->id === $img2->id) {
            return 0;
        }
        if ($img1->id > $img2->id) {
            return 1;
        }
        return -1;
    }

    /**
     * Route Controller constructor receives container
     *
     * @param ContainerInterface|null $container Slim app container instance
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->config = @include(__DIR__ . '/../../config/config.php');

        $dataDir = __DIR__ . '/../../' . $this->config['database']['dir'];
        $this->imageStore = new Store("images", $dataDir, [
            'auto_cache' => true,
            'timeout' => false
        ]);
        $this->tagStore = new Store("tags", $dataDir, [
            'auto_cache' => true,
            'timeout' => false
        ]);
    }


    /**
     * GET getImageInventory
     * Summary: Returns Tags
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function getImageInventory(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $images = $this->imageStore->findAll(["name" => "asc"]);
        $response->getBody()->write(json_encode($images));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * getImagesByTagName
     * Summary: Find Images by TangName
     * Notes: Returns tagged Images
     *
     * @param string $tagName Tagname
     *
     * @return array
     */
    private function getImagesByTagName($tagName)
    {
        $images = $this->imageStore->findBy( [function($image) use ($tagName) {
            return (in_array($tagName, $image['tags']));
        }]);
        return $images;
    }

    /**
     * GET findImagesByTag
     * Summary: Finds Images by tag
     * Notes: Muliple tags can be provided with comma separated strings. Use\\ \\ tag, mytag, anothertag for testing.
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function findImagesByTag(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $queryParams = $request->getQueryParams();
        $tags = (key_exists('tags', $queryParams)) ? $queryParams['tags'] : null;
        $sets = [];
        foreach ($tags as $tag) {
            $sets[] = $this->getImagesByTagName($tag);
        }
        // return intersection of image-sets
        $images = empty($sets) ? [] : array_uintersect(array_merge_recursive($sets), $sets, 'ImageApi::idCompare');

        $response->getBody()->write(json_encode($images));
        return $response->withHeader('Content-Type', 'application/json');
    }

}
