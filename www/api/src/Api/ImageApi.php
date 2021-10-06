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
    /**
     * Route Controller constructor receives container
     *
     * @param ContainerInterface|null $container Slim app container instance
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->imageStore = new Store("images", __ROOT_PATH__.'/data', [
            'auto_cache' => true,
            'timeout' => false
        ]);
        $this->tagStore = new Store("tags", __ROOT_PATH__.'/data', [
            'auto_cache' => true,
            'timeout' => false
        ]);
    }


    /**
     * GET getImageInventory
     * Summary: Returns Tags
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request  Request
     * @param ResponseInterface      $response Response
     * @param array|null             $args     Path arguments
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
     * GET getImagesByTagName
     * Summary: Find Images by TangName
     * Notes: Returns tagged Images
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request  Request
     * @param ResponseInterface      $response Response
     * @param array|null             $args     Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function getImagesByTagName(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $tagName = $args['tagName'];
        $tag = $this->tagStore->findOneBy(["name", "=", $tagName])[0];
        $images = [];
        foreach ($tag->images as $id){
            $image = $this->imageStore->findOneBy(["id", "=", $id])[0];
            $images[] = $image;
        }
        $response->getBody()->write(json_encode($images));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
