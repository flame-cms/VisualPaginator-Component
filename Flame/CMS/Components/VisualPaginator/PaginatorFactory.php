<?php
/**
 * Class PaginatorFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\CMS\Components\VisualPaginator;

use Nette\Object;

class PaginatorFactory extends Object implements IPaginatorControlFactory
{

	/**
	 * @return PaginatorControl
	 */
	public function create()
	{
		return new PaginatorControl;
	}
}