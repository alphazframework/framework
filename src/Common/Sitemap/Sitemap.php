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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common\Sitemap;

class Sitemap extends SitemapWriter
{
    /**
     * Start of sitemap.
     *
     * @since 3.0.0
     *
     * @var string
     */
    const START    = '<?xml version="1.0" encoding="UTF-8"?><urlset mlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

    /**
     * End of sitemap.
     *
     * @since 3.0.0
     *
     * @var string
     */    
    const END     = '</urlset>';

    /**
     * Priority.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $validFrequencies = [
        'always' , 'hourly', 'daily', 'weekly',
        'monthly', 'yearly', 'never',
    ];    

    /**
     * Priority.
     *
     * @since 3.0.0
     *
     * @var float
     */
    private $priority = 0.5;

    /**
     * Last modify.
     *
     * @since 3.0.0
     *
     * @var Datetime
     */
    private $lastMod;

    /**
     * Change frequency.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $changeFreq = 'weekly';

    /**
     * Sitemap file.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $file;

    /**
     * XML structure.
     *
     * @since 3.0.0
     *
     * @var string
     */    
    private $raw = '
    <url>
        <loc>:url</loc>
        <lastmod>:lastmod</lastmod>
        <changefreq>:changefreq</changefreq>
        <priority>:priority</priority>
    </url>';

    /**
     * __construct.
     * Specify file name wiht extension, the path will be the public
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 3.0.0
     *
     * @return void
    */    
    public function __construct($file)
    {
        $this->file = route()->public.$file;
        $this->lastMod = date('d:m:y');
    }

    /**
     * Create the sitemap.
     *
     * @param (siring) $mode       Valid mode (for only access inside class)
     * @param (string) $url        Valid url.
     * @param (string) $lastMod    Last modify.
     * @param (float)  $priority   Priority.
     * @param (string) $changeFreq changeFreq.
     *
     * @since 3.0.0
     *
     * @return bool
    */
    private function create($mode, $url, $lastMod = null, $priority = 0.5, $changeFreq = 'weekly')
    {
        [$lastMod, $priority, $changeFreq] = [$lastMod ?: $this->lastMod, $priority ?: $this->priority, $changeFreq ?: $this->changeFreq];
        if(!in_array($changeFreq, $this->validFrequencies, true)) {
            throw new \InvalidArgumentException("The value of changeFreq is not valid", 500);
        }       
        $raw = str_replace([':url', ':lastmod', ':changefreq',':priority'], [$url, $lastMod, $changeFreq, (float) $priority], $this->raw);
        if ($mode === 'create') {
            $fileH = new SitemapWriter($this->file, 'writeOnly');
            $fileH->write(Sitemap::START.PHP_EOL);
            $fileH->write($raw);
            $fileH->write(PHP_EOL.Sitemap::END);
        } elseif ($mode === 'append') {
            $fileH = new SitemapWriter($this->file, 'readOnly');
            $sitemapData = $fileH->read();
            $fileH = new SitemapWriter($this->file, 'writeOverride');
            $sitemapData = str_replace('</urlset>', '', $sitemapData);
            $sitemapData = $sitemapData . $raw;
            $fileH->write($sitemapData);
            $fileH->write(PHP_EOL.Sitemap::END);
        }
        $fileH->close();

        return true;
    }

    /**
     * Add item to sitemap.
     *
     * @param (string) $url        Valid url.
     * @param (string) $lastMod    Last modify.
     * @param (float)  $priority   Priority.
     * @param (string) $changeFreq changeFreq.
     *
     * @since 3.0.0
     *
     * @return void
    */
    public function addItem($url, $lastMod = null, $priority = 0.5, $changeFreq = 'weekly')
    {
        if ($this->has($this->file)) {
            $this->appendItem($url, $lastMod, $priority, $changeFreq);
        } else {
            $this->create('create', $url, $lastMod, $priority, $changeFreq);
        }
    }

    /**
     * Append item to sitemap.
     *
     * @param (string) $url        Valid url.
     * @param (string) $lastMod    Last modify.
     * @param (float)  $priority   Priority.
     * @param (string) $changeFreq changeFreq.
     *
     * @since 3.0.0
     *
     * @return void
    */
    private function appendItem($url, $lastMod, $priority, $changeFreq)
    {
        $this->create('append', $url, $lastMod, $priority, $changeFreq);
    }

    /**
     * Determine whether the sitemap exists.
     **
     * @since 3.0.0
     *
     * @return bool
    */
    public function has()
    {
        return file_exists($this->file) ? true : false;
    }

    /**
     * Delete the sitemap.
     *
     * @since 3.0.0
     *
     * @return object
    */
    public function delete()
    {
        if (file_exists($this->file)) {
            unlink($this->$file);
        }

        return $this;
    }

}
