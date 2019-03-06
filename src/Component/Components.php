<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 1.0.0
 *
 * @license MIT
 *
 */

namespace Zest\Component;

use Zest\Data\Conversion;
use Zest\Files\Files;

class Components
{
	public function getAll()
	{
		return Conversion::arrayObject(array_diff(scandir(route()->com), ['..', '.']));
	}	

	public function getById($id)
	{
		//return $this->getAll();
	}

	public function delete($name)
	{
		if (file_exists(route()->com.$name))
			(new Files())->deleteDir(route()->com.$name);

	}

	public function install()
	{

	}

	public function active($id)
	{

	}

	public function disable($id)
	{

	}

	public function moveToTrash($name)
	{

	}

	public function restoreFromTrash($name)
	{

	}	
}
