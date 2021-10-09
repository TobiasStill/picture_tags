<?php

namespace OpenAPIServer\Api;

use OpenAPIServer\Model\Tag;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SleekDB\Store;
use Slim\Exception\HttpNotImplementedException;

class ImageApi extends AbstractImageApi
{
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
        $this->imageStore = new Store("images", __ROOT_PATH__ . '/data', [
            'auto_cache' => true,
            'timeout' => false
        ]);
        $this->tagStore = new Store("tags", __ROOT_PATH__ . '/data', [
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
        $images = $this->imageStore->findAll(["id" => "asc"]);
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
    private function fetchImagesByTagName($tagName)
    {
        $tag = $this->tagStore->findOneBy(["name", "=", $tagName])[0];
        $images = [];
        foreach ($tag->images as $id) {
            $image = $this->imageStore->findOneBy(["id", "=", $id])[0];
            $images[] = $image;
        }
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
            $sets[] = $this->fetchImagesByTagName($tag);
        }
        // return intersection of image-sets
        $images = empty($sets) ? [] : array_uintersect(array_merge_recursive($sets), $sets, 'ImageApi::idCompare');
        $response->getBody()->write(json_encode($images));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
