<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExceptionController extends AbstractController
{
    public function showException()
    {
        return $this->render('PageNotFound.html.twig');
    }
}