<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\CityRequest;
use App\Entity\CountryRequest;
use App\Entity\Localization;
use App\Entity\Statuses\CommandStatus;
use App\Facade\AdminFacade;
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

        $cityLocalization = [];
        foreach ($rows as $row) {
            $cityLocalization[] = CityRequest::validation($row);
        }

        $response = $this->selectCityAction($cityLocalization, $command);

        return new Response($response);
    }

    /**
     * @param array $cityLocalization
     * @param string $command
     */
    private function selectCityAction(array $cityLocalization, string $command)
    {
        if ($command == CommandStatus::ADD_CITY) {

        }
    }
}