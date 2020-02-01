<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    public function index()
    {
        return $this->render('/tickets/index.html.twig');
    }
}
