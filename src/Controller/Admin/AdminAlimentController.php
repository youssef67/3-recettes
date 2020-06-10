<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliment", name="adminAliments")
     */
    public function aliments(AlimentRepository $repository)
    {
        $aliments = $repository->findAll();

        return $this->render('admin/adminAliments.html.twig', [
            'aliments' => $aliments
        ]);
    }

    /**
     * @Route("/admin/aliment/{id}", name="adminAliments_Modification")
     */
    public function modification(Aliment $aliment)
    {
        $form = $this->createForm(AlimentType::class, $aliment);

        return $this->render('admin/modificationAliment.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView()
        ]);
    }
}
