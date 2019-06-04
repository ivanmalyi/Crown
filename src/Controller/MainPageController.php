<?php

declare(strict_types=1);

namespace App\Controller;

use App\Facade\MainPageFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainPageController
 * @package App\Controller
 */
class MainPageController extends AbstractController
{

    /**
     * @Route("/")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadMainPage(Request $request)
    {
        $selectedLanguage = $request->query->get('selectedLanguage');

        if (!is_null($selectedLanguage)) {
            setcookie("Language", $selectedLanguage, time() * 2, '/');
            $language = $selectedLanguage;
        } else {
            $language = $_COOKIE['Language'] ?? $request->query->get('language');
            if (is_null($language)) {
                $language = 'ru';
            }
        }

        $mainPageFacade = new MainPageFacade($this->getDoctrine());
        $mainPageData = $mainPageFacade->mainContent($language);

        return $this->render('MainPage/MainPage.html.twig', ['MainPageData'=>$mainPageData]);
    }
}