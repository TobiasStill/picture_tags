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
 */

require_once __DIR__ . '/vendor/autoload.php';
use OpenAPIServer\SlimRouter;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use OpenAPIServer\Mock\OpenApiDataMocker;

const __ROOT_PATH__ = __DIR__;
$_ENV['SLIM_MODE'] = 'development';

// load config file
$config = @include(__DIR__ . 'config/config.php');

$router = new SlimRouter($config);
$app = $router->getSlimApp();

/**
 * The routing middleware should be added before the ErrorMiddleware
 * Otherwise exceptions thrown from it will not be handled
 */
$app->addRoutingMiddleware();

/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.

 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$app->addErrorMiddleware(
    $config['slimSettings']['displayErrorDetails'] ?? false,
    $config['slimSettings']['logErrors'] ?? true,
    $config['slimSettings']['logErrorDetails'] ?? true
);

$app->run();
