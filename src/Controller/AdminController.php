<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\Localization;
use App\Entity\Statuses\CommandStatus;
use App\Facade\LocalizationFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        return $this->render('AdminPanel/Auth.html.twig');
    }

    /**
     * @Route("/LocalizationAction")
     */
    public function actionLocalization(Request $request)
    {
        $data = $request->query->get('data');
        $command = $request->query->get('command');
        $login = $request->query->get('login');
        $password = $request->query->get('password');
        $localization = Localization::validation($data);

        $this->selectAction($localization, $command);
    }

    private function selectAction(Localization $localization, string $command)
    {
        $localizationFacade = new LocalizationFacade($this->getDoctrine());

        if ($command == CommandStatus::ADD_LOCALIZATION) {
            $localizationFacade->saveLocalization($localization);
        }
    }
}