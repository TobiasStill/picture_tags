<?php

namespace OpenAPIServer\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotImplementedException;
use SleekDB\Store;

class TagApi extends AbstractTagApi
{
    private $store;
    private $queryBuilder;

    /**
     * Route Controller constructor receives container
     *
     * @param ContainerInterface|null $container Slim app container instance
     */
    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
        $this->config = @include(__DIR__ . '../../config/config.php');
        $dataDir = __DIR__ . '/' . $this->config['database']['dir'];
        $this->store = new Store("tags", $dataDir, [
            'auto_cache' => true,
            'timeout' => false
        ]);
        $this->queryBuilder = $this->store->createQueryBuilder();
    }

    /**
     * GET getTagListing
     * Summary: Lists availlable Tags
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request  Request
     * @param ResponseInterface      $response Response
     * @param array|null             $args     Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function getTagListing(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $tags = $this->store->findAll(["name" => "asc"]);
        $response->getBody()->write(json_encode($tags));
        return $response->withHeader('Content-Type', 'application/json');
    }


    /**
     * POST addTag
     * Summary: Add a new tag to the tagcloud
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function addTag(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $tag = $this->store->insert([json_decode($body)]);
        $response->getBody()->write(json_encode($tag));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * DELETE deleteTag
     * Summary: Deletes a tag
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function deleteTag(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $tagName = $args['tagName'];
        $this->store->deleteBy(["name", "=", $tagName]);
        return $response;
    }

    /**
     * GET findTagsByAuthors
     * Summary: Finds Tags by author
     * Notes: Multiple authors can be provided with comma separated strings
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function findTagsByAuthor(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $author = $args['author'];
        if (empty($author)) {
            throw new Exception('invalid author name');
        }
        $tags = $this->store->findOneBy(["author", "=", $author]);
        $response->getBody()->write(json_encode($tags));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * GET getTagByTagName
     * Summary: Find Tag by TangName
     * Notes: Returns a single Tag
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function getTagByTagName(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $tagName = $args['name'];
        $tag = $this->store->findOneBy(["name", "=", $tagName]);
        $response->getBody()->write(json_encode($tag));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * PUT updateTag
     * Summary: Update an existing ta
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function updateTag(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $tag = $this->store->updateOrInsert([json_decode($body)]);
        $response->getBody()->write(json_encode($tag));
        return $response->withHeader('Content-Type', 'application/json');
    }

}
