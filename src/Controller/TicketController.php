<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TicketController
 *
 * This controller handles the frontend implementation of the ticket scanner.
 *
 * @package App\Controller
 */
class TicketController extends AbstractController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('/tickets/index.html.twig');
    }
}
