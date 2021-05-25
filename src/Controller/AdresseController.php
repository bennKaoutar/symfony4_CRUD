<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Modification;
use App\Form\AdresseType;
use App\Repository\AdresseRepository;
use App\Repository\ModificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/adresse")
 */
class AdresseController extends AbstractController
{
    /**
     * @Route("/", name="adresse_index", methods={"GET"})
     */
    public function index(AdresseRepository $adresseRepository, ModificationRepository $modificationRepository ): Response
    {

       
        return $this->render('adresse/index.html.twig', [
            'adresses' => $adresseRepository->findAll(),'modifications' => $modificationRepository->findBy(array('nom_table' => 'ADRESSE')),
        ]);
    }

    /**
     * @Route("/new", name="adresse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response 
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $modification = new Modification();
            $modification ->setNomTable("ADRESSE");
            $modification ->setDate(new \DateTime());
            $modification ->setHeure(new \DateTime());
            $modification->setOperation("AJOUT");

            $em = $this->getDoctrine()->getManager();
            $em->persist($modification);
            $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adresse);
            $entityManager->flush();

            return $this->redirectToRoute('adresse_index');
        }

        return $this->render('adresse/new.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adresse_show", methods={"GET"})
     */
    public function show(Adresse $adresse): Response
    {
        return $this->render('adresse/show.html.twig', [
            'adresse' => $adresse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="adresse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Adresse $adresse): Response
    {
        
       
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

      
        if ($form->isSubmitted() && $form->isValid()) {

            $modification = new Modification();
            $modification ->setNomTable("ADRESSE");
            $modification ->setDate(new \DateTime());
            $modification ->setHeure(new \DateTime());
            $modification->setOperation("MODIFICATION");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modification);
            $entityManager->flush();
            
            $this->getDoctrine()->getManager()->flush();

    

            return $this->redirectToRoute('adresse_index');
        }

        return $this->render('adresse/edit.html.twig', [
            'adresse' => $adresse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="adresse_delete", methods={"POST"})
     */
    public function delete(Request $request, Adresse $adresse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
            $modification = new Modification();
            $modification ->setNomTable("ADRESSE");
            $modification ->setDate(new \DateTime());
            $modification ->setHeure(new \DateTime());
            $modification->setOperation("SUPPRESSION");

            $em = $this->getDoctrine()->getManager();
            $em->persist($modification);
            $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adresse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adresse_index');
    }
}
