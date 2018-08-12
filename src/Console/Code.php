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
 * @license MIT
 */

namespace Zest\Console;

class Code
{
    public function controller($name)
    {
        return  <<<code
<?php

namespace App\Controllers;
//for using View
use Zest\View\View;

class {$name} extends \Zest\Controller\Controller
{
    /**
     * Show the index page.
     *
     * @return void
     */
    public function index()
    {
        echo View::view('{$name}/index');
    }
}

code;
    }
}
