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
 *
 */

namespace Softhub99\Zest_Framework\Communication\SSE;

class Event
{
    protected $id;
    protected $type;
    protected $data;
    protected $retry;
    protected $comment;

    /**
     * Event constructor.
     *
     * @param array $event [id=>id,type=>type,data=>data,retry=>retry,comment=>comment]
     */
    public function __construct(array $event)
    {
        $this->id = isset($event['id']) ? $event['id'] : null;
        $this->type = isset($event['type']) ? $event['type'] : null;
        $this->data = isset($event['data']) ? $event['data'] : null;
        $this->retry = isset($event['retry']) ? $event['retry'] : null;
        $this->comment = isset($event['comment']) ? $event['comment'] : null;
    }

    public function __toString()
    {
        $event = [];
        strlen($this->comment) > 0 and $event[] = sprintf(': %s', $this->comment); //:comments
        strlen($this->id) > 0 and $event[] = sprintf('id: %s', $this->id);
        strlen($this->retry) > 0 and $event[] = sprintf('retry: %s', $this->retry); //millisecond
        strlen($this->type) > 0 and $event[] = sprintf('event: %s', $this->type);
        strlen($this->data) > 0 and $event[] = sprintf('data: %s', $this->data);

        return implode("\n", $event)."\n\n";
    }
}
