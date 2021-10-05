<?php

namespace OpenAPIServer\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotImplementedException;

class TagApi extends AbstractTagApi
{
    private $tagStore;
    private $queryBuilder;

    /**
     * Route Controller constructor receives container
     *
     * @param ContainerInterface|null $container Slim app container instance
     */
    public function __construct(ContainerInterface $container = null)
    {
        $databaseDirectory = realpath('../data');
        $this->container = $container;
        $this->tagStore = new \SleekDB\Store("news", $databaseDirectory);
        $this->queryBuilder = $this->tagStore->createQueryBuilder();
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
        $tag = $this->tagStore->insert([json_decode($body)]);
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
        $this->tagStore->deleteBy(["name", "=", $tagName]);
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
    public function findTagsByAuthors(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $queryParams = $request->getQueryParams();
        $author = (key_exists('author', $queryParams)) ? $queryParams['author'] : null;
        if (empty($author)) {
            throw new Exception('invalid author name');
        }
        $tags = $this->tagStore->findBy(["author", "=", $author]);
        $response->getBody()->write(json_encode($tags));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * GET findTagsByImage
     * Summary: Finds Tags by image
     * Notes: Muliple images can be provided with comma separated strings. Use\\ \\ 1, 2, 3 for testing.
     * Output-Formats: [application/json, application/xml]
     *
     * @param ServerRequestInterface $request Request
     * @param ResponseInterface $response Response
     * @param array|null $args Path arguments
     *
     * @return ResponseInterface
     * @throws HttpNotImplementedException to force implementation class to override this method
     */
    public function findTagsByImage(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $queryParams = $request->getQueryParams();
        $image = (key_exists('images', $queryParams)) ? $queryParams['images'] : null;
        if (empty($image)) {
            throw new Exception('invalid images string');
        }
        $tags = $this->queryBuilder
            ->where([["images", "=", "[" . $image . "]"], 'OR', ["images", "like", "[" . $image . ",%"], "OR", ["images", "like", "%," . $image . ",%"]])
            ->getQuery()->fetch();
        $response->getBody()->write(json_encode($tags));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * GET getInventory
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
    public function getInventory(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $tags = $this->tagStore->findAll(["name" => "asc"]);
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
        $tagName = $args['tagName'];
        $tag = $this->tagStore->findOneBy(["name", "=", $tagName]);
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
        $tag = $this->tagStore->updateOrInsert([json_decode($body)]);
        $response->getBody()->write(json_encode($tag));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
