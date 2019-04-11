<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/AdminPanel")
     */
    public function index()
    {
        return $this->render('AdminPanel/Auth.html.twig');
    }

    /**
     * @Route("/AdminPanel/auth")
     */
    public function adminPanel()
    {
        //return $this->render('AdminPanel/AdminPanel.html.twig');
        echo 10;
    }
}