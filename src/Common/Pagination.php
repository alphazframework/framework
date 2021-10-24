<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common;

class Pagination
{
    /**
     * Total items.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $totalItems;

    /**
     * Item per page.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $itemPerPage = 6;

    /**
     * Current page.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $current;

    /**
     * Site base url.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Url append.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $urlAppend;

    /**
     * ul tag class.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $ulCLass;

    /**
     * li tag class.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $liClass;

    /**
     * a tag class.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $aClass;

    /**
     * __construct.
     *
     * @param (int)    $items     int total count.
     * @param (int)    $perPage   item in per page.
     * @param (int)    $current   current page.
     * @param (string) $urlAppend sub url.
     * @param (string) $ulClass   ul class value.
     * @param (string) $liClass   li class value.
     * @param (string) $aClass    a class value
     *
     * @since 3.0.0
     */
    public function __construct($total = 10, $perPage = 6, $current = 1, $urlAppend = '/', $ulCLass = 'pagination', $liClass = 'page-item', $aClass = 'page-link')
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
     * @param $append int sub url to be appended
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function setUrlAppend($append)
    {
        $this->urlAppend = $append;
    }

    /**
     * Set the current page.
     *
     * @param (int) $current current page.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function setCurrentPage($current)
    {
        return ($current >= 0) ? $this->current = $current : false;
    }

    /**
     * Set the base url.
     *
     * @since 3.0.0
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
     * @param(int) $items item per page item.
     *
     * @since 3.0.0
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
     * @param (int) $items total item count.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function setTotalItems($items)
    {
        return ($items > 0) ? $this->totalItems = $items : false;
    }

    /**
     * Generate pagination link.
     *
     * @param (int) $number page number.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function generateLink($number)
    {
        return $this->baseUrl.$this->urlAppend.$number.' ';
    }

    /**
     * Generate the pagination.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function pagination()
    {
        $pageCount = ceil($this->totalItems / $this->itemPerPage);
        if ($this->current >= 1 && $this->current <= $pageCount) {
            $current_range = [($this->current - 2 < 1 ? 1 : $this->current - 2), ($this->current + 2 > $pageCount ? $pageCount : $this->current + 2)];
            $first_page = $this->current > 5 ? '<li><a href="'.$this->baseUrl.$this->urlAppend.'1'.'" class="'.$this->aClass.'">'.printl('first:page:pagination').'</a></li>'.($this->current < 5 ? ', ' : ' <li class="'.$this->liClass.'"><a href="#!" class="'.$this->aClass.' disable" disabled >...</a></li> ') : null;
            $last_page = $this->current < $pageCount - 2 ? ($this->current > $pageCount - 4 ? ', ' : ' <li class="'.$this->liClass.' disable"><a href="#!" class="'.$this->aClass.'" disabled >...</a></li>  ').'<li><a href="'.$this->baseUrl.$this->urlAppend.$pageCount.'" class="'.$this->aClass.'">'.printl('last:page:pagination').'</a></li>' : null;
            $previous_page = $this->current > 1 ? '<li class="'.$this->liClass.'"><a class="'.$this->aClass.'"href="'.$this->baseUrl.$this->urlAppend.($this->current - 1).'">'.printl('prev:page:pagination').'</a></li>  ' : null;
            $next_page = $this->current < $pageCount ? '  <li class="'.$this->liClass.'"><a class="'.$this->aClass.'" href="'.$this->baseUrl.$this->urlAppend.($this->current + 1).'">'.printl('next:page:pagination').'</a></li>' : null;
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
     * @since 3.0.0
     *
     * @return mixed
     */
    public function __toString()
    {
        $this->pagination();
    }
}
