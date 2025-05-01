<?php

declare(strict_types=1);

namespace App\Weather\Ports\Http\Ui\Controllers;

use App\Weather\Ports\Http\Ui\Forms\CityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShowCurrentWeatherAction extends AbstractController
{
    public function __construct()
    {
    }

    #[Route(path: '/', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return $this->render('@Weather\current.html.twig', [
            'form' => $this->createForm(CityFormType::class)
        ]);
    }
}