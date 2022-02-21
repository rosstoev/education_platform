<?php
declare(strict_types=1);

namespace App\Controller;


use App\Form\RegistrationType;
use App\Handler\UserHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public const SUCCESS_REGISTRATION_PATH = [
        1 => 'teacher_login',
        2 => 'student_login'
    ];

    /**
     * @Route ("/", name="home_page")
     */
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route ("/register", name="register")
     */
    public function register(Request $request, UserHandler $userHandler, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userHandler->register($user);
            $em->flush();

            $this->addFlash('registerSuccess', 'Регистрацията е успешна.');

            return $this->redirectToRoute(self::SUCCESS_REGISTRATION_PATH[$user->getType()]);
        }


        return $this->render('pages/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}