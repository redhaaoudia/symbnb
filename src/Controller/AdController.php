<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo,SessionInterface $session)
    {
        

        $ads=$repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }
    
    /**
     * Permet de créer une annonce 
     * 
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Responce
     */
    public function create(Request $request, EntityManagerInterface $manager){
        $ad=new Ad();

     
        
        $form=$this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        

       if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }            

           $manager->persist($ad);
           $manager->flush();


           $this->addFlash(
            'success',
            "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
        );
        

           return $this->redirectToRoute('ads_show' , [
               'slug'=>$ad->getSlug()
           ]);
       }

        return $this->render('ad/new.html.twig',[
            'form' =>$form->createView()
        ]);
    }

    /**
     *Permet d'afficher le formulaire d'édition
     *
     *@Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * @return Response
     */
    public function edit(Ad $ad, Request $request){
    
    $manager=$this->getdoctrine()->getManager();

    $form=$this->createForm(AdType::class, $ad);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        foreach($ad->getImages() as $image) {
            $image->setAd($ad);
            $manager->persist($image);
        }            

       $manager->persist($ad);
       $manager->flush();


       $this->addFlash(
        'success',
        "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
    );
    

       return $this->redirectToRoute('ads_show' , [
           'slug'=>$ad->getSlug()
       ]);
   }


        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad'=> $ad
        ]);
    }

    /**
     * permet d'afficher une seule annonce 
     *
     * @Route("/ads/{slug}",name="ads_show")
     * 
     * @return Response
     */

    public function show(Ad $ad){
        //je recupère l'annonce qui correspond au slug !
        // $ad=$repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig' , [
            'ad' =>$ad
        ]);
    }

}
