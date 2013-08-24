<?php

namespace Flame\CMS\Components\VisualPaginator;

/**
 * Nette Framework Extras
 *
 * This source file is subject to the New BSD License.
 *
 * For more information please see http://extras.nettephp.com
 *
 * @copyright  Copyright (c) 2009 David Grudl
 * @license    New BSD License
 * @link       http://extras.nettephp.com
 * @package    Nette Extras
 * @version    $Id: VisualPaginator.php 4 2009-07-14 15:22:02Z david@grudl.com $
 */

use Nette\Application\UI;


/**
 * Visual paginator control.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2009 David Grudl
 * @package    Nette Extras
 */
class PaginatorControl extends UI\Control
{

	const ITEMS_PER_PAGE = 10;

	/** @var \Nette\Utils\Paginator */
	private $paginator;

	/** @var  string */
	private $templateFile;

	/** @persistent */
	public $page = 1;
	
	public function __construct()
	{
		parent::__construct();

		$this->getPaginator()->setItemsPerPage(self::ITEMS_PER_PAGE);
		$this->templateFile = __DIR__ . '/templates/PaginatorControl.latte';
	}

	/**
	 * @return \Nette\Utils\Paginator
	 */
	public function getPaginator()
	{
		if (!$this->paginator) {
			$this->paginator = new \Nette\Utils\Paginator;
		}

		return $this->paginator;
	}

	/**
	 * Renders paginator.
	 *
	 * @return void
	 */
	public function render()
	{
		$this->template->steps = $this->getSteps();
		$this->template->paginator = $this->getPaginator();
		$this->template->setFile($this->templateFile)->render();
	}

	/**
	 * @return array
	 */
	public function getSteps()
	{
		$paginator = $this->getPaginator();
		$page = $paginator->page;
		if ($paginator->pageCount < 2) {
			$steps = array($page);

		} else {
			$arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
			$count = 4;
			$quotient = ($paginator->pageCount - 1) / $count;
			for ($i = 0; $i <= $count; $i++) {
				$arr[] = round($quotient * $i) + $paginator->firstPage;
			}
			sort($arr);
			$steps = array_values(array_unique($arr));
		}

		return $steps;
	}

	/**
	 * Loads state information.
	 *
	 * @param  array
	 * @return void
	 */
	public function loadState(array $params)
	{
		parent::loadState($params);
		$this->getPaginator()->page = $this->page;
	}

	/**
	 * @param $limit
	 * @return $this
	 */
	public function setItemsPerPage($limit)
	{
		$this->getPaginator()->setItemsPerPage($limit);
		return $this;
	}

	/**
	 * @param $count
	 * @return $this
	 */
	public function setItemCount($count)
	{
		$this->getPaginator()->setItemCount((int) $count);
		return $this;
	}

	/**
	 * @param string $templateFile
	 * @return $this
	 */
	public function setTemplateFile($templateFile)
	{
		$this->templateFile = $templateFile;
		return $this;
	}

	/**
	 * @param array $items
	 * @return array
	 */
	public function applyFor(array &$items)
	{
		$this->setItemCount(count($items));
		return array_slice($items, $this->getPaginator()->getOffset(), $this->getPaginator()->getLength());
	}

}
