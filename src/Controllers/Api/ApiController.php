<?php
namespace Exedron\Lex\Controllers\Api;

use Exedra\Routing\Group;
use Exedra\Routing\Route;
use Exedron\Lex\Context;
use Exedron\Lex\Controllers\BaseController;

class ApiController extends BaseController
{
    public function middleware(Context $context)
    {
        $context->set('map', function(Context $context) {
            return $context->_app->map;
        });

        $context->response->setHeader('Content-Type', 'application/json');

        return json_encode(array(
            'data' => $context->next($context, $context->map)
        ));
    }

    /**
     * @name base
     */
    public function get()
    {
    }

    /**
     * @name all-routes
     * @tag zzz
     * @path /all-routes
     * @attr.hello world
     */
    public function getAllRoutes(Context $context, Group $group)
    {
        $routes = array();

        if($context->param('group'))
            $group = $group->findRoute($context->param('group'));

        $group->each(function(Route $route) use(&$routes, $context) {
            $execute = $route->getProperty('execute');

            if(is_string($execute)) {
                $action = $execute;

                if(strpos($action, 'routeller=') === 0)
                    $action = str_replace('routeller=', '', $action);
            } else {
                if(is_object($execute) && $execute instanceof \Closure) {
                    $ref = new \ReflectionFunction($execute);

                    $rootDir = $context->_app->getRootDir();

                    $action = ltrim(str_replace($rootDir, '', $ref->getFileName()), '\\/') . ' (' . $ref->getStartLine() . ')';
                } else {
                    $action = '(' . gettype($execute) . ')';
                }
            }

            $routes[] = array(
                'name' => $route->getAbsoluteName(),
                'method' => count($route->getMethod()) == 6 ? 'any' : strtoupper(implode(', ', $route->getMethod())),
                'path' => '/' . $route->getPath(true),
                'attributes' => $route->getAttributes(),
                'has_attributes' => count($route->getAttributes()) > 0,
                'tag' => $route->hasProperty('tag') ? $route->getProperty('tag') : null,
                'action' => $action,
                'is_executable' => $route->hasExecution(),
                'is_group' => $route->hasSubroutes()
            );
        }, true);

        return $routes;
    }
}