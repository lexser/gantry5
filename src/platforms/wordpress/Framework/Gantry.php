<?php
namespace Gantry\Framework;

use Gantry\Component\Config\Config;

class Gantry extends Base\Gantry
{
    /**
     * @param string $location
     * @param bool   $force
     * @return array
     */
    public function styles($location = 'head', $force = false)
    {
        // Do not display head, WordPress will take care of it (most of the time).
        return (!$force && in_array($location, ['head', 'footer'])) ? [] : parent::styles($location);
    }

    /**
     * @param string $location
     * @param bool $force
     * @return array
     */
    public function scripts($location = 'head', $force = false)
    {
        // Do not display head, WordPress will take care of it (most of the time).
        return (!$force && in_array($location, ['head', 'footer'])) ? [] : parent::scripts($location);
    }

    /**
     * @throws \LogicException
     */
    protected static function load()
    {
        // Make sure Timber plugin has been loaded.
        if ( !class_exists( 'Timber' ) ) {
            throw new \LogicException( 'Timber not activated. Make sure you activate the plugin in <a href="' . admin_url( 'plugins.php#timber' ) . '">' . admin_url( 'plugins.php' ) . '</a>' );
        }

        $container = parent::load();

        $container['site'] = function ( $c ) {
            return new Site;
        };

        $container['page'] = function ( $c ) {
            return new Page( $c );
        };

        $container['global'] = function ($c) {
            return new Config([]);
        };

        return $container;
    }
}
