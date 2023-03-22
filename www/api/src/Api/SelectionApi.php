<?php

namespace OpenAPIServer\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SleekDB\Store;

class SelectionApi extends AbstractSelectionApi
{
    public function __construct(ContainerInterface $container = null)
    {
        parent::__construct($container);
        $this->config = @include(__DIR__ . '../../config/config.php');
        $dataDir = __DIR__ . '/' . $this->config['database']['dir'];
        $this->store = new Store("selection", $dataDir, [
            'auto_cache' => true,
            'timeout' => false
        ]);
    }

    public function addImageSelection(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $selection = $this->store->insert([json_decode($body)]);
        $response->getBody()->write(json_encode($selection));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteImageSelection(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        $this->store->deleteById($id);
        return $response;
    }

    public function getImageSelectionById(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id'];
        $selection = $this->store->findById($id);
        $response->getBody()->write(json_encode($selection));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateImageSelection(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $body = $request->getParsedBody();
        $selection = $this->store->updateOrInsert([json_decode($body)]);
        $response->getBody()->write(json_encode($selection));
        return $response->withHeader('Content-Type', 'application/json');
    }

}
