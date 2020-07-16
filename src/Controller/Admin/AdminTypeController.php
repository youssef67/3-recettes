<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeFormType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Security\Csrf\CsrfToken;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin/types", name="admin_types")
     */
    public function types(TypeRepository $repository)
    {
        $types = $repository->findAll();

        return $this->render('admin/adminTypes.html.twig', [
            'types' => $types
        ]);
    }

    /**
     * @Route("/admin/type/{id}", name="admin_modif_type", methods="GET|POST")
     * @Route("/admin/type/ajout", name="admin_ajout_type")
     */

    /**
     * @Route("/admin/type/{id}", name="admin_modif_type", methods="GET|POST")
     * @Route("/admin/type/ajout", name="admin_ajout")
     */
    public function ajoutEtModif(Type $type = null, Request $request, EntityManagerInterface $manager)
    {
        if (!$type)
        {
            $type = new Type();
        }

        $form = $this->createForm(TypeFormType::class, $type);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $modif = $type->getId() !== null;
            $manager->persist($type);
            $manager->flush();
            $this->addFlash("success", $modif ? "la modification a été effectué" : "l'ajout a été effectué");
            return $this->redirectToRoute("admin_types");
        }

        return $this->render('admin/modifEtAjoutTypes.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
            'isModification' => $type->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/type/{id}", name="admin_suppression_type", methods="delete")
     */
    public function suppression(Type $type, Request $request, EntityManagerInterface $manager)
    {
        if ($this->isCsrfTokenValid('SUP' . $type->getId(), $request->get('_token')))
        {
            $manager->remove($type);
            $manager->flush();
            $this->addFlash('success', 'type supprimé');
            return $this->redirectToRoute("admin_types");
        }
    }
}
