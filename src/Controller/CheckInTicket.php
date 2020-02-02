<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Event\TicketCheckedInEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CheckInTicket
 *
 * @package App\Controller
 */
class CheckInTicket
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * CheckInTicket constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Ticket $data
     *
     * @return Ticket
     * @throws \Exception
     */
    public function __invoke(Ticket $data): Ticket
    {
        if (true === $data->hasCheckedIn()) {
            return $data;
        }

        $data->setCheckedInAt(new \DateTime());

        $event = new TicketCheckedInEvent($data);
        $this->eventDispatcher->dispatch($event, TicketCheckedInEvent::NAME);

        return $data;
    }
}
