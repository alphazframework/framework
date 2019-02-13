<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest;

use Zest\Common\AliasLoader;
use Zest\Common\TimeZone;
use Zest\Router\App;

class Bootstrap
{
    /**
     * Set Default configuration.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function configure()
    {
        TimeZone::seteDefaultTz(__config()->config->timezone);
    }

    /**
     * Register the class aliases.
     *
     * @since 3.0.0
     *
     * @return void
     */
    protected function registerClassAliases()
    {
        $aliases = __config()->class_aliases;
        if (!empty($aliases)) {
            $aliasLoader = new AliasLoader($aliases);
            spl_autoload_register([$aliasLoader, 'load']);
        }
    }

    /**
     * Register the App.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function registerApp()
    {
        $app = new App();
        $app->run();
    }

    /**
     * Boot the application.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function boot()
    {
        //Set default configuration
        $this->configure();
        //Loaded class aliases
        $this->registerClassAliases();
        //register the app
        $this->registerApp();
    }
}
