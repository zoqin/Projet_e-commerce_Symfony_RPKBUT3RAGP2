<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LanguageController extends AbstractController
{
    #[Route('/change_locale/{locale}', name: 'change_locale')]
    public function changeLocale(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);

        $referer = $request->headers->get('referer');
        if($referer) {
            $referer = preg_replace('#/(en|fr)/#', '/'.$locale.'/', $referer, 1);
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('home', ['_locale' => $locale]);
    }
}
