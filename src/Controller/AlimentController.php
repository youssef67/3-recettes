<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="aliments")
     */
    public function aliments(AlimentRepository $repository)
    {
        $aliments = $repository->findAll();

        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => false
        ]);
    }

    /**
     * @Route("/aliments/calorie/{calorie}", name="alimentsParCalorie")
     */
    public function alimentParCalories(AlimentRepository $repository, $calorie)
    {
        $aliments = $repository->getAlimentParPropritete('calorie', '<', $calorie);

        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true,
            'isGlucide' => false
        ]);
    }

    /**
     * @Route("/aliments/glucide/{glucide}", name="alimentsParGlucide")
     */
    public function alimentsParGlucide(AlimentRepository $repository, $glucide)
    {
        $aliments = $repository->getAlimentParPropritete('glucide', '<' ,$glucide );

        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => true
        ]);
    }
}
