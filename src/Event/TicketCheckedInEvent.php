<?php

namespace App\Event;

use App\Entity\Ticket;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class TicketCheckedInEvent
 *
 * @package App\Event
 */
class TicketCheckedInEvent extends Event
{
    public const NAME = 'ticket.checked_in';

    /**
     * @var Ticket
     */
    protected $ticket;

    /**
     * TicketCheckedInEvent constructor.
     *
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return Ticket
     */
    public function getTicket(): Ticket
    {
        return $this->ticket;
    }
}
