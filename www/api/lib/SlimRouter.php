<?php

/**
 * PictureTag
 * PHP version 7.2
 *
 * @package OpenAPIServer
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */

/**
 * This is a sample Tagcloud server for images.
 * The version of the OpenAPI document: 1.0.0
 * Contact: apiteam@swagger.io
 * Generated by: https://github.com/openapitools/openapi-generator.git
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */
namespace OpenAPIServer;

use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteInterface;
use Slim\Exception\HttpNotImplementedException;
use Psr\Container\ContainerInterface;
use InvalidArgumentException;
use Dyorg\TokenAuthentication;
use Dyorg\TokenAuthentication\TokenSearch;
use Psr\Http\Message\ServerRequestInterface;
use OpenAPIServer\Middleware\JsonBodyParserMiddleware;
use OpenAPIServer\Mock\OpenApiDataMocker;
use OpenAPIServer\Mock\OpenApiDataMockerRouteMiddleware;
use Slim\Psr7\Factory\ResponseFactory;
use Exception;

/**
 * SlimRouter Class Doc Comment
 *
 * @package OpenAPIServer
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */
class SlimRouter
{

    /** @var App instance */
    private $slimApp;

    /** @var array[] list of all api operations */
    private $operations = [
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/image/findByTag',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractImageApi',
            'userClassname' => 'ImageApi',
            'operationId' => 'findImagesByTag',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Image"
        }
      }
    },
    "application/xml" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Image"
        }
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid image value",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/images',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractImageApi',
            'userClassname' => 'ImageApi',
            'operationId' => 'getImageInventory',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Image"
        }
      }
    },
    "application/xml" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Image"
        }
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid Request",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/image/srcSet/{name}',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractImageApi',
            'userClassname' => 'ImageApi',
            'operationId' => 'getSrcSet',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Image"
        }
      }
    },
    "application/xml" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Image"
        }
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid image value",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'POST',
            'basePathWithoutHost' => '/api',
            'path' => '/selection',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractSelectionApi',
            'userClassname' => 'SelectionApi',
            'operationId' => 'addImageSelection',
            'responses' => [
                '405' => [
                    'jsonSchema' => '{
  "description" : "Invalid input",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'PUT',
            'basePathWithoutHost' => '/api',
            'path' => '/selection',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractSelectionApi',
            'userClassname' => 'SelectionApi',
            'operationId' => 'updateImageSelection',
            'responses' => [
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid ID supplied",
  "content" : { }
}',
                ],
                '404' => [
                    'jsonSchema' => '{
  "description" : "Tag not found",
  "content" : { }
}',
                ],
                '405' => [
                    'jsonSchema' => '{
  "description" : "Validation exception",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'DELETE',
            'basePathWithoutHost' => '/api',
            'path' => '/selection/{id}',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractSelectionApi',
            'userClassname' => 'SelectionApi',
            'operationId' => 'deleteImageSelection',
            'responses' => [
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid name supplied",
  "content" : { }
}',
                ],
                '404' => [
                    'jsonSchema' => '{
  "description" : "Tag not found",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/selection/{id}',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractSelectionApi',
            'userClassname' => 'SelectionApi',
            'operationId' => 'getImageSelectionById',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "$ref" : "#/components/schemas/ImageSelection"
      }
    },
    "application/xml" : {
      "schema" : {
        "$ref" : "#/components/schemas/ImageSelection"
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid name supplied",
  "content" : { }
}',
                ],
                '404' => [
                    'jsonSchema' => '{
  "description" : "Tag not found",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'POST',
            'basePathWithoutHost' => '/api',
            'path' => '/tag',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractTagApi',
            'userClassname' => 'TagApi',
            'operationId' => 'addTag',
            'responses' => [
                '405' => [
                    'jsonSchema' => '{
  "description" : "Invalid input",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/tag-list',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractTagApi',
            'userClassname' => 'TagApi',
            'operationId' => 'getTagListing',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "type" : "string"
        }
      }
    },
    "application/xml" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "type" : "string"
        }
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid Request",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'PUT',
            'basePathWithoutHost' => '/api',
            'path' => '/tag',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractTagApi',
            'userClassname' => 'TagApi',
            'operationId' => 'updateTag',
            'responses' => [
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid ID supplied",
  "content" : { }
}',
                ],
                '404' => [
                    'jsonSchema' => '{
  "description" : "Tag not found",
  "content" : { }
}',
                ],
                '405' => [
                    'jsonSchema' => '{
  "description" : "Validation exception",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'DELETE',
            'basePathWithoutHost' => '/api',
            'path' => '/tag/{name}',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractTagApi',
            'userClassname' => 'TagApi',
            'operationId' => 'deleteTag',
            'responses' => [
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid name supplied",
  "content" : { }
}',
                ],
                '404' => [
                    'jsonSchema' => '{
  "description" : "Tag not found",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/tag/byAuthor/{author}',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractTagApi',
            'userClassname' => 'TagApi',
            'operationId' => 'findTagsByAuthor',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Tag"
        }
      }
    },
    "application/xml" : {
      "schema" : {
        "type" : "array",
        "items" : {
          "$ref" : "#/components/schemas/Tag"
        }
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid status value",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
        [
            'httpMethod' => 'GET',
            'basePathWithoutHost' => '/api',
            'path' => '/tag/{name}',
            'apiPackage' => 'OpenAPIServer\Api',
            'classname' => 'AbstractTagApi',
            'userClassname' => 'TagApi',
            'operationId' => 'getTagByTagName',
            'responses' => [
                '200' => [
                    'jsonSchema' => '{
  "description" : "successful operation",
  "content" : {
    "application/json" : {
      "schema" : {
        "$ref" : "#/components/schemas/Tag"
      }
    },
    "application/xml" : {
      "schema" : {
        "$ref" : "#/components/schemas/Tag"
      }
    }
  }
}',
                ],
                '400' => [
                    'jsonSchema' => '{
  "description" : "Invalid name supplied",
  "content" : { }
}',
                ],
                '404' => [
                    'jsonSchema' => '{
  "description" : "Tag not found",
  "content" : { }
}',
                ],
            ],
            'authMethods' => [
            ],
        ],
    ];

    /**
     * Class constructor
     *
     * @param ContainerInterface|array $settings Either a ContainerInterface or an associative array of app settings
     *
     * @throws HttpNotImplementedException When implementation class doesn't exists
     * @throws Exception when not supported authorization schema type provided
     */
    public function __construct($settings = [])
    {
        if ($settings instanceof ContainerInterface) {
            // Set container to create App with on AppFactory
            AppFactory::setContainer($settings);
        }
        $this->slimApp = AppFactory::create();

        // middlewares requires Psr\Container\ContainerInterface
        $container = $this->slimApp->getContainer();


        $userOptions = $this->getSetting($settings, 'tokenAuthenticationOptions', null);

        // mocker options
        $mockerOptions = $this->getSetting($settings, 'mockerOptions', null);
        $dataMocker = $mockerOptions['dataMocker'] ?? new OpenApiDataMocker();
        $responseFactory = new ResponseFactory();
        $getMockStatusCodeCallback = $mockerOptions['getMockStatusCodeCallback'] ?? null;
        $mockAfterCallback = $mockerOptions['afterCallback'] ?? null;

        foreach ($this->operations as $operation) {
            $callback = function ($request, $response, $arguments) use ($operation) {
                $message = "How about extending {$operation['classname']} by {$operation['apiPackage']}\\{$operation['userClassname']} class implementing {$operation['operationId']} as a {$operation['httpMethod']} method?";
                throw new HttpNotImplementedException($request, $message);
            };
            $middlewares = [new JsonBodyParserMiddleware()];

            if (class_exists("\\{$operation['apiPackage']}\\{$operation['userClassname']}")) {
                $callback = "\\{$operation['apiPackage']}\\{$operation['userClassname']}:{$operation['operationId']}";
            }


            if (is_callable($getMockStatusCodeCallback)) {
                $mockSchemaResponses = array_map(function ($item) {
                    return json_decode($item['jsonSchema'], true);
                }, $operation['responses']);
                $middlewares[] = new OpenApiDataMockerRouteMiddleware($dataMocker, $mockSchemaResponses, $responseFactory, $getMockStatusCodeCallback, $mockAfterCallback);
            }

            $this->addRoute(
                [$operation['httpMethod']],
                "{$operation['basePathWithoutHost']}{$operation['path']}",
                $callback,
                $middlewares
            )->setName($operation['operationId']);
        }
    }

    /**
     * Merges user defined options with dynamic params
     *
     * @param array $staticOptions Required static options
     * @param array $userOptions   User options
     *
     * @return array Merged array
     */
    private function getTokenAuthenticationOptions(array $staticOptions, array $userOptions = null)
    {
        if (is_array($userOptions) === false) {
            return $staticOptions;
        }

        return array_merge($userOptions, $staticOptions);
    }

    /**
     * Returns app setting by name.
     *
     * @param ContainerInterface|array $settings    Either a ContainerInterface or an associative array of app settings
     * @param string                   $settingName Setting name
     * @param mixed                    $default     Default setting value.
     *
     * @return mixed
     */
    private function getSetting($settings, $settingName, $default = null)
    {
        if ($settings instanceof ContainerInterface && $settings->has($settingName)) {
            return $settings->get($settingName);
        } elseif (is_array($settings) && array_key_exists($settingName, $settings)) {
            return $settings[$settingName];
        }

        return $default;
    }

    /**
     * Add route with multiple methods
     *
     * @param string[]        $methods     Numeric array of HTTP method names
     * @param string          $pattern     The route URI pattern
     * @param callable|string $callable    The route callback routine
     * @param array|null      $middlewares List of middlewares
     *
     * @return RouteInterface
     *
     * @throws InvalidArgumentException If the route pattern isn't a string
     */
    public function addRoute(array $methods, string $pattern, $callable, $middlewares = [])
    {
        $route = $this->slimApp->map($methods, $pattern, $callable);
        foreach ($middlewares as $middleware) {
            $route->add($middleware);
        }
        return $route;
    }

    /**
     * Returns Slim Framework instance
     *
     * @return App
     */
    public function getSlimApp()
    {
        return $this->slimApp;
    }
}
