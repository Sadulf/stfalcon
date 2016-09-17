<?php

namespace StfalconBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use StfalconBundle\Entity\Image;
use StfalconBundle\Entity\Tag;

//use StfalconBundle\Form\ImageType;

class RestapiController extends Controller
{

    public function uploadAction(Request $request)
    {

        // perform some request validation and get file and data

        if ($request->getMethod() != 'POST')
            return $this->json(['status' => 'error', 'error' => 'Invalid request']);

        $file = $request->files->get('image');

        if (!$file)
            return $this->json(['status' => 'error', 'error' => 'File upload error (1)']);

        if ($file->error != UPLOAD_ERR_OK OR $file->size < 3
            OR strpos($file['mimeType'], 'image') !== 0)
            return $this->json(['status' => 'error', 'error' => 'File upload error (2)']);

        $dir = realpath($this->container->getParameter('kernel.root_dir') . '/..' . DIRECTORY_SEPARATOR . 'web') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        if (!is_dir($dir))
            @mkdir($dir);

        $fileName = $this->makeName($dir, $file['originalName']);
        if (is_null($fileName))
            return $this->json(['status' => 'error', 'error' => 'File upload error (3)']);

        if(move_uploaded_file($file['pathName'], $dir . $fileName) !== true)
            return $this->json(['status' => 'error', 'error' => 'File upload error (4)']);


        // add image to DB

        $image = new Image();
        $image->setName($fileName);
        $image->setDescription(trim($request->request->get('description', '')));
        $image->setTitle(trim($request->request->get('title', '')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($image);
        $em->flush();

        // add tags (if any) to DB
        $tags = explode(',',$request->request->get('tags', ''));
        if(count($tags) > 0){
            $tagids = [];
            foreach($tags as $v)
                $tagids[] = $this->addTag(trim($v));

            print_r($tagids);
        }

        $imageId = $image->getId();


        // replace this example code with whatever you need
        return $this->render('StfalconBundle::webclient.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
            'debug' => print_r($request, 1),

        ));
    }

    public function deleteAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    public function addtagsAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    public function deltagsAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    public function listAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    public function searchAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }



    private function addTag($name){
        $r = $this->getDoctrine()
            ->getRepository('AppBundle:Tag')
            ->findOneByTag($name);
        if(is_null($r)){
            $tag = new Tag();
            $tag->setTag($name);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            return $tag->getId();
        }
        return $r->getId();
    }

    private function makeName($dir, $name, $step = 0)
    {
        if ($step == 0)
            if (!file_exists($dir . $name))
                return $name;

        if ($step > 10)
            return null;

        $n = rand(0, 999);
        if (file_exists($dir . $n . $name))
            return $this->makeName($dir, $name, $step + 1);

        return $n . $name;
    }

    private function json($vals)
    {
        $response = new Response();
        $response->setContent(json_encode($vals));
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
