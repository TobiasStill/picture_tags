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
namespace OpenAPIServer\Model;

use OpenAPIServer\BaseModel;

/**
 * Note
 *
 * @package OpenAPIServer\Model
 * @author  OpenAPI Generator team
 * @link    https://github.com/openapitools/openapi-generator
 */
class Note extends BaseModel
{
    /**
     * @var string Models namespace.
     * Can be required for data deserialization when model contains referenced schemas.
     */
    protected const MODELS_NAMESPACE = '\OpenAPIServer\Model';

    /**
     * @var string Constant with OAS schema of current class.
     * Should be overwritten by inherited class.
     */
    protected const MODEL_SCHEMA = <<<'SCHEMA'
{
  "required" : [ "author", "date", "note" ],
  "type" : "object",
  "properties" : {
    "author" : {
      "type" : "string"
    },
    "note" : {
      "type" : "string"
    },
    "date" : {
      "type" : "string",
      "format" : "date"
    }
  },
  "xml" : {
    "name" : "Note"
  }
}
SCHEMA;
}
