<?php
namespace Ben\UserBundle\Controller;
 
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;


use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
    
        
        $form = $this->getForm($request);
        
        $user = $form->getData();

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        //$form->setData($user);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
       
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    

    
    public function renderformAction( Request $request )
    {
//        $user_profile = $request->query->get('data');
        $form = $this->getForm($request);
        $html = $this->renderView('FOSUserBundle:Registration:filter_area.html.twig', array('form' => $form->createView()));
        
        return new Response($html);     
    }  

    
    private function getForm(Request $request)
    {
        if(null !== $request->query->get('data')){
            $user_profile = $request->query->get('data');
        }
        else {
            $user_profile = $request->request->get('ben_user_registration', false)['profil'];
        }

        $form = $this->createForm($this->getFormType($user_profile), $this->getEntity($user_profile));
        return $form;
    }
    
    private function getEntity($user_profile)
    {
        switch ($user_profile) {
            case '2':
                return new \AppBundle\Entity\User\Farmer();         
            default:
                return new \AppBundle\Entity\User\User();
        }
    }

    private function getFormType($user_profile)
    {       
        switch ($user_profile) {
            case '2':
                return 'AppBundle\Form\User\FarmerType';         
            default:
                return 'Ben\UserBundle\Form\RegistrationType';
        }
    }
}