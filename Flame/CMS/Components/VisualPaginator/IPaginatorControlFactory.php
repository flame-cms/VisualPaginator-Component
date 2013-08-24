<?php
/**
 * IPaginatorFactory.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    18.12.12
 */

namespace Flame\CMS\Components\VisualPaginator;

interface IPaginatorControlFactory
{

	/**
	 * @return PaginatorControl
	 */
	public function create();

}
