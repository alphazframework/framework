<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common\Sitemap;

use Zest\Contracts\Sitemap\Sitemap as SitemapContracts;

class Sitemap extends AbstractSitemap implements SitemapContracts
{
    /**
     * Start of sitemap.
     *
     * @since 3.0.0
     *
     * @var string
     */
    const START = '<?xml version="1.0" encoding="UTF-8"?><urlset mlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

    /**
     * End of sitemap.
     *
     * @since 3.0.0
     *
     * @var string
     */
    const END = '</urlset>';

    /**
     * Priority.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $validFrequencies = [
        'always', 'hourly', 'daily', 'weekly',
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
     * Change frequency.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $changeFreq = 'weekly';

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
     * Specify file name with extension, the path will be public.
     *
     * @param (string) $file File name with extension (.xml).
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = __public_path().$file.$this->ext;
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
    private function create($mode, $url, $lastMod = null, $priority = 0.5, $changeFreq = 'weekly'):void
    {
        [$lastMod, $priority, $changeFreq] = [$lastMod ?: $this->lastMod, $priority ?: $this->priority, $changeFreq ?: $this->changeFreq];
        if (!in_array($changeFreq, $this->validFrequencies, true)) {
            throw new \InvalidArgumentException('The value of changeFreq is not valid', 500);
        }
        $raw = str_replace([':url', ':lastmod', ':changefreq', ':priority'], [$url, $lastMod, $changeFreq, (float) $priority], $this->raw);
        if ($mode === 'create') {
            $fileH = new SitemapWriter($this->file, 'writeOnly');
            $fileH->write(self::START.PHP_EOL);
            $fileH->write($raw);
            $fileH->write(PHP_EOL.self::END);
            $fileH->close();
        } elseif ($mode === 'append') {
            $fileH = new SitemapWriter($this->file, 'readOnly');
            $sitemapData = $fileH->read();
            $fileH = new SitemapWriter($this->file, 'writeOverride');
            $sitemapData = str_replace('</urlset>', '', $sitemapData);
            $sitemapData = $sitemapData.$raw;
            $fileH->write($sitemapData);
            $fileH->write(PHP_EOL.self::END);
            $fileH->close();
        }
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
    public function addItem($url, $lastMod = null, $priority = 0.5, $changeFreq = 'weekly'):void
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
    private function appendItem($url, $lastMod, $priority, $changeFreq):void
    {
        $this->create('append', $url, $lastMod, $priority, $changeFreq);
    }
}
