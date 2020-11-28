<?php

namespace Zest\Console\Commands;
use Zest\Console\Command;
use Zest\Cache\Cache as CacheManager;

class Cache extends Command
{
    protected $sign = "clear:cache";
    protected $description = "Clear the application cache";

    public function handle()
    {
        $c = new CacheManager();
        $c->clear();
        $this->write("<green>Cache cleared</green>");
    }

}