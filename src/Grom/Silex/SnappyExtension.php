<?php

namespace Grom\Silex;

use Silex\Application;
use Silex\ExtensionInterface;
use Knp\Snappy\Image;
use Knp\Snappy\Pdf;

/**
 * Silex extension to integrate Snappy library.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class SnappyExtension implements ExtensionInterface
{
    public function register(Application $app)
    {
        $app['snappy.image'] = $app->share(function () use ($app) {
            return new Image(
                isset($app['snappy.image_binary']) ? $app['snappy.image_binary'] : '/usr/local/bin/wkhtmltoimage',
                isset($app['snappy.image_options']) ? $app['snappy.image_options'] : array()
            );
        });

        $app['snappy.pdf'] = $app->share(function () use ($app) {
            return new Pdf(
                isset($app['snappy.pdf_binary']) ? $app['snappy.pdf_binary'] : '/usr/local/bin/wkhtmltopdf',
                isset($app['snappy.pdf_options']) ? $app['snappy.pdf_options'] : array()
            );
        });

        if (isset($app['snappy.class_path'])) {
            $app['autoloader']->registerNamespace('Knp\\Snappy', $app['snappy.class_path']);
        }
    }
}
