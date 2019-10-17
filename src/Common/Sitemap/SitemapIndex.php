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

use Zest\Contracts\Sitemap\SitemapIndex as SitemapIndexContracts;

class SitemapIndex extends AbstractSitemap implements SitemapIndexContracts
{
    /**
     * Start of sitemap.
     *
     * @since 3.0.0
     *
     * @var string
     */
    const START = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    /**
     * End of sitemap.
     *
     * @since 3.0.0
     *
     * @var string
     */
    const END = '</sitemapindex>';

    /**
     * XML structure.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $raw = '
    <sitemap>
        <loc>:url</loc>
        <lastmod>:lastmod</lastmod>
    </sitemap>';

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
     * @param (siring) $mode    Valid mode (for only access inside class)
     * @param (string) $url     Valid url.
     * @param (string) $lastMod Last modify.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    private function create($mode, $url, $lastMod = null):void
    {
        $lastMod = $lastMod ?: $this->lastMod;
        $raw = str_replace([':url', ':lastmod'], [$url, $lastMod], $this->raw);
        if ($mode === 'create') {
            $fileH = new SitemapWriter($this->file, 'writeOnly');
            $fileH->write(self::START.PHP_EOL);
            $fileH->write($raw);
            $fileH->write(PHP_EOL.self::END);
        } elseif ($mode === 'append') {
            $fileH = new SitemapWriter($this->file, 'readOnly');
            $sitemapData = $fileH->read();
            $fileH = new SitemapWriter($this->file, 'writeOverride');
            $sitemapData = str_replace('</sitemapindex>', '', $sitemapData);
            $sitemapData = $sitemapData.$raw;
            $fileH->write($sitemapData);
            $fileH->write(PHP_EOL.self::END);
        }
        $fileH->close();
    }

    /**
     * Add item to sitemap.
     *
     * @param (string) $url     Valid url.
     * @param (string) $lastMod Last modify.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function addItem($url, $lastMod = null):void
    {
        if ($this->has($this->file)) {
            $this->appendItem($url, $lastMod);
        } else {
            $this->create('create', $url, $lastMod);
        }
    }

    /**
     * Append item to sitemap.
     *
     * @param (string) $url     Valid url.
     * @param (string) $lastMod Last modify.
     *
     * @since 3.0.0
     *
     * @return void
     */
    private function appendItem($url, $lastMod):void
    {
        $this->create('append', $url, $lastMod);
    }
}
