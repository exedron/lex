<?php
namespace Exedron\Lex;

use Exedron\Lex\Controllers\MainController;
use Exedron\Routeller\RoutellerProvider;

class Application extends \Exedra\Application
{
    public function setUp()
    {
        parent::setUp();
        $this->setUpServices();
        $this->setUpProviders();
        $this->setUpRouting();
    }

    public function setUpProviders()
    {
        $this->provider->add(RoutellerProvider::class);
    }

    public function setUpServices()
    {
        $this->config->set('env', json_decode($this->path->file('config/env.json')->getContents(), true));

        $this->set('@_app', function(Application $app) {
            return require $app->config->get('env.app_path');
        });

        $this['factory']->set('runtime.context', Context::class);

        $this->set('@twig', function(Application $app) {
            $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($app->path->to('views')));

            $twig->addGlobal('url', $app->url);

            return $twig;
        });
    }

    public function setUpRouting()
    {
        $this->map['error']->get('/404')->execute(function() {

        });

        $this->map['main']->group(MainController::class);
    }
}