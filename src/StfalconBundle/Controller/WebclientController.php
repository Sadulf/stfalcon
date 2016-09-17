<?php

namespace StfalconBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use StfalconBundle\Form\ImageType;
use StfalconBundle\Entity\Image;

class WebclientController extends Controller
{

    public function indexAction(Request $request)
    {
        //$image = new Image();
       // $form = $this->createForm(ImageType::class, $image);

        return $this->render('StfalconBundle::webclient.html.twig', [
            'debug'=>'',
        ]);
    }

}
