<?php
namespace Exedron\Lex;

use Exedra\Application;
use Exedra\Routing\Group;

/**
 * @property \Twig_Environment $twig
 * @property Application $_app
 * @property Group $map
 */
class Context extends \Exedra\Runtime\Context
{
    public function render($view, array $data = array())
    {
        return $this->twig->render($view, $data);
    }
}