<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index($request): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home',
        ]);
    }

    #[Route('/request', name: 'request')]
    public function dumpRequest(Request $request): Response
    {
        if (!$request->query->has('name')) {
            return new Response("No name found in the request");
        }
        return new Response($request->query->get('name'));
    }

    #[Route('/cv', name: 'cv')]
    public function cv(Request $request, SessionInterface $session): Response
    {
        $first_name = $session->get('first_name');
        $last_name =  $session->get('last_name');
        $age =  $session->get('age');
        $section =  $session->get('section');

        if (!$first_name || !$last_name || !$age || !$section) {
            $first_name = $request->query->get('first_name');
            $last_name = $request->query->get('last_name');
            $age = $request->query->get('age');
            $section = $request->query->get('section');

            if (!$first_name || !$last_name || !$age || !$section) {
                return new Response("Please provide all the required fields");
            }

            $session->set('first_name', $first_name);
            $session->set('last_name', $last_name);
            $session->set('age', $age);
            $session->set('section', $section);
        }

        return $this->render('cv.html.twig');
    }

    #[Route('/{name}', name: 'hello')]
    public function hello(Request $request, $name): Response
    {
        $response = new Response("<h1> Hello " . $name . " !</h1>");
        return $response;
    }
}
