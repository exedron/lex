<?php
require_once __DIR__ . '/vendor/autoload.php';

\Exedra\Support\Autoloader::getInstance()->autoloadPsr4('Exedron\\Lex\\', __DIR__ . '/src/');

$app = new \Exedron\Lex\Application(__DIR__);

return $app;