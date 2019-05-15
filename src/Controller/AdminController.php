<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\CityRequest;
use App\Entity\ColorRequest;
use App\Entity\CountryRequest;
use App\Entity\Localization;
use App\Entity\Statuses\CommandStatus;
use App\Facade\AdminFacade;
use App\Facade\CityFacade;
use App\Facade\ColorFacade;
use App\Facade\CountryFacade;
use App\Facade\LocalizationFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/AdminPanel/auth")
     */
    public function index()
    {
        return $this->render('AdminPanel/Auth.html.twig');
    }

    /**
     * @Route("/AdminPanel")
     */
    public function adminPanel(Request $request)
    {
        $login = $request->query->get('login');
        $password = $request->query->get('password');

        if ($login == 'SMBAdmin' and $password == '!QAZ2wsx#EDC') {
            return $this->render('AdminPanel/AdminPanel.html.twig',
                [
                    'login' =>'SMBAdmin',
                    'inputLogin'=>$login,
                    'password'=>'!QAZ2wsx#EDC',
                    'inputPassword'=>$password
                ]
            );
        }
        $adminFacade = new AdminFacade($this->getDoctrine());
        $adminData = $adminFacade->findMainData();


       // return $this->render('AdminPanel/Auth.html.twig');
        return $this->render('AdminPanel/AdminPanel.html.twig', ['adminData'=>$adminData]);
    }

    /**
     * @Route("/LocalizationAction")
     *
     * @param Request $request
     * @return Response
     */
    public function actionLocalization(Request $request)
    {
        $data = $request->query->get('data');
        $command = $request->query->get('command');

        $localization = Localization::validation($data);
        $response = $this->selectLocalizationAction($localization, $command);

        return new Response($response);
    }

    /**
     * @param Localization $localization
     * @param string $command
     * @return int|string
     */
    private function selectLocalizationAction(Localization $localization, string $command)
    {
        $localizationFacade = new LocalizationFacade($this->getDoctrine());

        if ($command == CommandStatus::ADD_LOCALIZATION) {
            $response = $localizationFacade->saveLocalization($localization);
        } elseif ($command == CommandStatus::FIND_LOCALIZATION) {
            $response = $localizationFacade->findLocalization($localization);
        } elseif ($command == CommandStatus::UPDATE_LOCALIZATION) {
            $response = $localizationFacade->updateLocalization($localization);
        }

        return $response;
    }

    /**
     * @Route("/CountryAction")
     *
     * @param Request $request
     * @return Response
     */
    public function actionCountry(Request $request)
    {
        $data = json_decode($request->query->get('data'), true);
        $command = $request->query->get('command');

        $countryRequest = CountryRequest::validation($data);
        $response = $this->selectCountryAction($countryRequest, $command);

        return new Response($response);
    }

    /**
     * @param CountryRequest $countryRequest
     * @param string $command
     * @return int|string
     */
    private function selectCountryAction(CountryRequest $countryRequest, string $command)
    {
        $countryFacade = new CountryFacade($this->getDoctrine());
        if ($command == CommandStatus::ADD_COUNTRY) {
            $response = $countryFacade->saveCountry($countryRequest);
        } elseif ($command == CommandStatus::FIND_COUNTRY) {
            $response = $countryFacade->findCountry($countryRequest->getCountry()->getId());
        } elseif ($command == CommandStatus::UPDATE_COUNTRY) {
            $response = $countryFacade->updateCountry($countryRequest);
        }

        return $response;
    }

    /**
     * @Route("/CityAction")
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

        $response = $this->selectCityAction($cityRequest, $command);

        return new Response($response);
    }

    /**
     * @param array $cityRequest
     * @param string $command
     * @return int|string
     */
    private function selectCityAction(array $cityRequest, string $command)
    {
        $cityFacade = new CityFacade($this->getDoctrine());
        if ($command == CommandStatus::ADD_CITY) {
            $response = $cityFacade->saveCity($cityRequest);
        } elseif ($command == CommandStatus::FIND_CITIES_FOR_COUNTRY){
            $response = $cityFacade->findCitiesForCountry($cityRequest);
        } elseif ($command == CommandStatus::FIND_CITY) {
            $response = $cityFacade->findCity($cityRequest);
        } elseif ($command == CommandStatus::UPDATE_CITY) {
            $response = $cityFacade->updateCity($cityRequest);
        }

        return $response;
    }

    /**
     * @Route("/ColorAction")
     *
     * @param Request $request
     * @return Response
     */
    public function actionColor(Request $request)
    {
        $rows = json_decode($request->query->get('data'), true);
        $command = $request->query->get('command');

        $colorRequest = [];
        foreach ($rows as $row) {
            $colorRequest[] = ColorRequest::validation($row);
        }

        $response = $this->selectColorAction($colorRequest, $command);

        return new Response($response);
    }

    /**
     * @param array $colorRequest
     * @param string $command
     * @return int|string
     */
    private function selectColorAction(array $colorRequest, string $command)
    {
        $colorFacade = new ColorFacade($this->getDoctrine());
        if ($command == CommandStatus::ADD_COLOR) {
            $response = $colorFacade->saveColor($colorRequest);
        } elseif ($command == CommandStatus::FIND_COLOR) {
            $response = $colorFacade->findColor($colorRequest);
        } elseif ($command == CommandStatus::UPDATE_COLOR) {
            $response = $colorFacade->updateColor($colorRequest);
        }

        return $response;
    }
}