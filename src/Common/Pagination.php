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

namespace Zest\Common;

class Pagination
{
    /*
     * Total items
    */
    private $totalItems;
    /*
     * Item per page
    */
    private $itemPerPage = 6;
    /*
    * Current page
    */
    private $current;
    /*
     * Site base url
    */
    private $baseUrl;
    /*
    * Url append
    */
    private $urlAppend;
    /*
     * ul tag class
    */
    private $ulCLass;
    /*
     * li tag class
    */
    private $liClass;
    /*
     * a tag class
    */
    private $aClass;
    /**
     * __construct.
     *
     * @param  $items int total count
     *         $perPage item in per page
     *         $current current page
     *         $urlAppend sub url
     *
     * @return void
     */
    public function __construct($total = 10, $perPage = 6, $current = 1, $urlAppend = '/', $ulCLass = 'pagination', $liClass = 'page-item' , $aClass = 'page-link')
    {
        $this->setTotalItems($total);
        $this->setItmPerPage($perPage);
        $this->setCurrentPage($current);
        $this->setBaseUrl();
        $this->setUrlAppend($urlAppend);
        $this->ulCLass = $ulCLass;
        $this->liClass = $liClass;
        $this->aClass = $aClass;
    }

    /**
     * Append the url.
     *
     * @param  $append int sub url to be appended
     *
     * @return bool
     */
    public function setUrlAppend($append)
    {
        $this->urlAppend = $append;
    }

    /**
     * Set the current page.
     *
     * @param  $current int current page
     *
     * @return bool
     */
    public function setCurrentPage($current)
    {
        return ($items >= 0) ? $this->current = $current : false;
    }

    /**
     * Set the base url.
     *
     * @return object
     */
    public function setBaseUrl()
    {
        $this->baseUrl = site_base_url();

        return $this;
    }

    /**
     * Set the per page item.
     *
     * @param  $items int per page item
     *
     * @return bool
     */
    public function setItmPerPage($item)
    {
        return ($item > 0) ? $this->itemPerPage = $item : false;
    }

    /**
     * Set the total items.
     *
     * @param  $items int total count
     *
     * @return bool
     */
    public function setTotalItems($items)
    {
        return ($items > 0) ? $this->totalItems = $items : false;
    }

    public function generateLink($number)
    {
        return $this->baseUrl.$this->urlAppend.$number.' ';
    }

    /**
     * Generate the pagination.
     *
     * @return HTML
     */
    public function pagination()
    {
        $pageCount = ceil($this->totalItems / $this->itemPerPage);
		if ($this->current >= 1 && $this->current <= $pageCount){
			$current_range = [($this->current - 2 < 1 ? 1 : $this->current - 2), ($this->current + 2 > $pageCount ? $pageCount : $this->current + 2)];
			$first_page = $this->current > 5 ? '<li><a href="'.$this->baseUrl.$this->urlAppend.'1'.'">'.printl('first:page:pagination').'</a></li>'.($this->current < 5 ? ', ' : ' <li class="'.$this->liClass.'"><a href="#!" class="'.$this->aClass.' disable" disabled >...</a></li> ') : null;
			$last_page = $this->current < $pageCount - 2 ? ($this->current > $pageCount - 4 ? ', ' : ' <li class="'.$this->liClass.' disable"><a href="#!" class="'.$this->aClass.'" disabled >...</a></li>  ').'<li><a href="'.$this->baseUrl.$this->urlAppend.$pageCount.'">'.printl('last:page:pagination').'</a></li>' : null;
			$previous_page = $this->current > 1 ? '<li class="'.$this->liClass.'"><a class="'.$this->aClass.'"href="'.$this->baseUrl.$this->urlAppend.($this->current - 1).'">Previous</a></li> | ' : null;
			$next_page = $this->current < $pageCount ? ' | <li class="'.$this->liClass.'"><a class="'.$this->aClass.'" href="'.$this->baseUrl.$this->urlAppend.($this->current + 1).'">Next</a></li>' : null;
			for ($x = $current_range[0]; $x <= $current_range[1]; $x++) {
				$pages[] = '<li class="'.$this->liClass.'"active"><a class="'.$this->aClass.'" href="'.$this->baseUrl.$this->urlAppend.$x.'" '.($x == $this->current ? 'class="'.$this->aClass.'"' : '').'>'.$x.'</a></li>';
			}
			if ($pageCount > 1) {
				return '<ul class="'.$this->ulCLass.'"> '.$previous_page.$first_page.implode(', ', $pages).$last_page.$next_page.'</ul>';
			}			
		}
    }

    /**
     * __Tostring.
     *
     * @return void
     */
    public function __toString()
    {
        $this->pagination();
    }
}
