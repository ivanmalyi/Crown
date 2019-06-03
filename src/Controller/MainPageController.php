<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainPageController
 * @package App\Controller
 */
class MainPageController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function loadMainPage()
    {
        
    }
}