<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\CityRequest;
use App\Entity\FilterRequest;
use App\Entity\Statuses\CommandStatus;
use App\Facade\CityFacade;
use App\Facade\MainPageFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $data = $request->query->get('data');

        if (!is_null($data)) {
            $filterRequest = FilterRequest::validation(json_decode($data, true));
        }

        $language = $this->findLocalization($request);
        $mainPageFacade = new MainPageFacade($this->getDoctrine());
        $mainPageData = $mainPageFacade->mainContent($language, $filterRequest ?? null);

        return $this->render('MainPage/MainPage.html.twig', ['MainPageData'=>$mainPageData]);
    }

    /**
     * @param Request $request
     * @return string
     */
    private function findLocalization(Request $request): string
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

        return $language;
    }

    /**
     * @Route("/MainPageCityAction")
     *
     * @param Request $request
     * @return Response
     */
    public function actionCity(Request $request)
    {
        $rows = json_decode($request->query->get('data'), true);
        $command = $request->query->get('command');

        $cityRequest = [];
        foreach ($rows as $row) {
            $cityRequest[] = CityRequest::validation($row);
        }

        $language = $this->findLocalization($request);
        $response = $this->selectCityAction($cityRequest, $command, $language);

        return new Response($response);
    }

    /**
     * @param array $cityRequest
     * @param string $command
     * @param string $language
     * @return string
     */
    private function selectCityAction(array $cityRequest, string $command, string $language)
    {
        $cityFacade = new CityFacade($this->getDoctrine());
        if ($command == CommandStatus::FIND_CITY_FOR_COUNTRY_WITH_LOCALIZATION) {
            $response = $cityFacade->findCitiesWithLocalization($cityRequest, $language);
        }

        return $response;
    }
}