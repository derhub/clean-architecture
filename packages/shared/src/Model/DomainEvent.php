<?php
/**
 * Created By: Johnder Baul<imjohnderbaul@gmail.com>
 * Date: 3/28/21
 */

namespace Derhub\Shared\Model;

use Derhub\Shared\Message\Event\Event;

/**
 * @template T
 */
interface DomainEvent extends Event
{
    /**
     * @return T
     */
    public function aggregateRootId(): string;
}
