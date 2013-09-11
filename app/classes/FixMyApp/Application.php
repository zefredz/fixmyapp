<?php namespace FixMyApp;

class Application extends \Silex\Application
{
    use \Silex\Application\TwigTrait;
    use \Silex\Application\SecurityTrait;
    use \Silex\Application\FormTrait;
    use \Silex\Application\UrlGeneratorTrait;
    use \Silex\Application\SwiftmailerTrait;
    use \Silex\Application\MonologTrait;
    use \Silex\Application\TranslationTrait;
}
