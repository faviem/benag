<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactType;
use AppBundle\Form\ContactHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     * @Cache(smaxage="600", public="true")
     */
    public function indexAction(Request $request)
    {        
        //  Message a envoyer en cas d'erreur
        $msg = '';
        //  Le formulaire

        $form = $this->createForm('AppBundle\Form\ContactType');
        
        $formHandler = new ContactHandler($form, $request, $this->container);
        //  On exécute le traitement du formulaire. S'il retourne true, alors le formulaire a bien été traité
        if ($formHandler->process()) {
            // On récupère le service translator
            $translator = $this->get('translator');
            $msg = $translator->trans('Message envoyé. Merci !');
        }
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'form' => $form->createView(), 
            'msg' => $msg
        ]);
    }    
}
