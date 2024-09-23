<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class AppController extends AbstractController
{
    #[Route(name: 'app', methods: ['GET'])]
    public function index()
    {
        return $this->render('base.html.twig');
    }

}
