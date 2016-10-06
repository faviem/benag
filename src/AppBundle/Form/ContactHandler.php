<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

/**
 * Description of ContactHandler
 *
 * @author Jacques
 */

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class ContactHandler
{
    protected $form;
    protected $request;
    protected $container;

    public function __construct(Form $form, Request $request, $container)
    {
        $this->form = $form;
        $this->request = $request;
        $this->container = $container;
    }

    public function process()
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->handleRequest($this->request);
            if ($this->form->isValid()) {
                $this->onSuccess($this->form->getData());

                return true;
            }
        }

        return false;
    }

    public function onSuccess($data)
    {
        //  Récupération du service pour l'envoi du mail
        $mailer = $this->container->get('mailer');
        //  Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
        $app_name = $this->container->getParameter('from_name');
        $contact_email = $this->container->getParameter('contact_email');
        //  Le message à à envoyer
        $msg = nl2br($data['message']);
        //  .'<br/><br/>Téléphone: '.$data["telephone"];
        $msg .= '<br /><br />';
        $msg .= 'Merci de bien vouloir répondre à ce message dans les 24H !';
        //  On définit le corps du message
        $message = \Swift_Message::newInstance()
        ->setSubject($data['objet'])
        ->setFrom(array($data['email'] => $data['nom']))
        //  .' '.$data["prenom"])
        ->setTo(array($contact_email => $app_name))
        ->setBody($msg)
        ->setContentType(' text/html');
        // Retour au service mailer, nous utilisons sa méthode « send()» pour envoyer notre $message
        $mailer->send($message);

        return true;
    }
}
