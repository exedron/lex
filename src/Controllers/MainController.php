<?php
namespace Exedron\Lex\Controllers;

use Exedron\Lex\Context;
use Exedron\Lex\Controllers\Api\ApiController;
use Exedron\Routeller\Controller\Controller;

class MainController extends Controller
{
    /**
     * @path /
     */
    public function get(Context $context)
    {
        return $context->render('main.twig', array(
            'app' => $context->_app
        ));
    }

    /**
     * @path /apis
     */
    public function groupApis()
    {
        return ApiController::class;
    }
}