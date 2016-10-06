<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

    // ...

    set_include_path(__DIR__.'/../vendor_zend'.PATH_SEPARATOR.get_include_path());
    require_once __DIR__.'/../vendor_zend/Zend/Loader/Autoloader.php';
    Zend_Loader_Autoloader::getInstance();

return $loader;