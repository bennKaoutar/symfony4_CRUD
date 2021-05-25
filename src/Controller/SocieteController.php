<?php

namespace App\Controller;

use App\Entity\Societe;
use App\Entity\Modification;
use App\Form\SocieteType;
use App\Repository\SocieteRepository;
use App\Repository\ModificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SocieteController extends AbstractController
{
    /**
     * @Route("/", name="societe_index", methods={"GET"})
     */
    public function index(SocieteRepository $societeRepository,ModificationRepository $modificationRepository): Response
    {
        return $this->render('societe/index.html.twig', [
            'societes' => $societeRepository->findAll(),'modifications' => $modificationRepository->findBy(array('nom_table' => 'SOCIETE')),
        ]);
    }

    /**
     * @Route("/new", name="societe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $societe = new Societe();
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modification = new Modification();
            $modification ->setNomTable("SOCIETE");
            $modification ->setDate(new \DateTime());
            $modification ->setHeure(new \DateTime());
            $modification->setOperation("AJOUT");

            $em = $this->getDoctrine()->getManager();
            $em->persist($modification);
            $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($societe);
            $entityManager->flush();

            return $this->redirectToRoute('societe_index');
        }

        return $this->render('societe/new.html.twig', [
            'societe' => $societe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="societe_show", methods={"GET"})
     */
    public function show(Societe $societe): Response
    {
        return $this->render('societe/show.html.twig', [
            'societe' => $societe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="societe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Societe $societe): Response
    {
        $form = $this->createForm(SocieteType::class, $societe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $modification = new Modification();
            $modification ->setNomTable("SOCIETE");
            $modification ->setDate(new \DateTime());
            $modification ->setHeure(new \DateTime());
            $modification->setOperation("MODIFICATION");

            $em = $this->getDoctrine()->getManager();
            $em->persist($modification);
            $em->flush();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('societe_index');
        }

        return $this->render('societe/edit.html.twig', [
            'societe' => $societe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="societe_delete", methods={"POST"})
     */
    public function delete(Request $request, Societe $societe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$societe->getId(), $request->request->get('_token'))) {
            $modification = new Modification();
            $modification ->setNomTable("SOCIETE");
            $modification ->setDate(new \DateTime());
            $modification ->setHeure(new \DateTime());
            $modification->setOperation("SUPPRESSION");

            $em = $this->getDoctrine()->getManager();
            $em->persist($modification);
            $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($societe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('societe_index');
    }
}
