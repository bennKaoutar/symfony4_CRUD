<?php

namespace App\EventsListener;

use App\Entity\Adresse;
use App\Entity\Societe;
use App\Entity\Modification;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;



class ModificationsListener extends AbstractController
{
  


    /**
     * @param LifecycleEventArgs $args
     */


    public function preUpdate(LifecycleEventArgs $args): void
    {
        $modification = new Modification();
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
    

        
        if ($entity instanceof Adresse) {
             // code relatif a la mise a jour d'une adresse
          
             try{
            
          /*    $modification = new Modification();
              $modification ->setNomTable("ADRESSE");
              $modification ->setDate(new \DateTime());
              $modification ->setHeure(new \DateTime());
  
              //dd($modification);
  
              $em = $this->getDoctrine()->getManager();
              $em->persist($modification);
              $em->flush();*/
             }
             catch (\Exception $e) {
              throw $e; //no error
          }
           
        }

        else if ($entity instanceof Societe) {
          // code relatif a la mise a jour d'une societe
        }
    }

    
   
}