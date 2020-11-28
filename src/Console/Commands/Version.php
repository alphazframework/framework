<?php

namespace Zest\Console\Commands;
use Zest\Console\Command;
use Zest\Common\Version as V;

class Version extends Command
{
    protected $sign = "version";
    protected $description = "Get the version of Zest framework installed";

    public function handle()
    {
        $this->write(V::VERSION);
    }

}