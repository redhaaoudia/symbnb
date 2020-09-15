<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class HomeController extends AbstractController {
    /**
     * @Route("/bonjour/{prenom}/age/{age}",name="hello")
     * @Route("/bonjour", name="hello_base")
     * @Route("/bonjour/{prenom}", name="hello_prenom")
     * Montre la page qui dit bonjour
     *
     * @return void
     */
    public function hello($prenom="anonyme" , $age=0 ){
        return $this->render(
            'hello.html.twig',
            ['prenom'=> $prenom,
            'age'=>$age
            ]
        );

        
    }
    /**
     * @Route("/", name="homepage") 
     *
     *
     */

    public function home(){
        $prenom = ["redha"=>20,"benoit"=>34,"jean"=>56];
        return $this->render(
                'home.html.twig',

                [
                    'title'=> "redha ",
                    'age' => 12,
                    'tableau' => $prenom
                ]

        );
    }
}


?>