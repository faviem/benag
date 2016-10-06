<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Vente;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Commande;

/**
 * Vente controller.
 *
 * @Route("/market")
 */
class VenteController extends Controller
{
    /**
     * Lists all Vente entities.
     *
     * @Route("/", name="vente_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();
        
        // pagination http://stackoverflow.com/questions/14817817/symfony-knppaginator-query-with-custom-filters-from-form-fields
        // http://achreftlili.github.io/2015/08/23/Ajaxify-Knp-Bundle-pagination/
        $dql   = "SELECT o FROM AppBundle:Vente o";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            24/*limit per page*/
        );
        return $this->render('vente/index.html.twig', array(
//            'ventes' => $ventes,
            'pagination' => $pagination,
            'categories' => $categories
        ));
    }

    /**
     * Creates a new Vente entity.
     *
     * @Route("/new", name="vente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vente = new Vente();
        $form = $this->createForm('AppBundle\Form\VenteType', $vente);
        $form->handleRequest($request);
        $user = $this->getUser();

        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $vente->setUser($user);
              
            $category_id = $request->request->get('vente')['product']['category'];

            $category = $em->getRepository('AppBundle:Category')->find($category_id);
        
            $vente->setProductCategroy($category->getName());
            
            $em->persist($vente);
            $em->flush();

            return $this->redirectToRoute('vente_show', array('id' => $vente->getId()));
        }

        return $this->render('vente/new.html.twig', array(
            'vente' => $vente,
            'form' => $form->createView(),
            
        ));
    }
    /**
     * Creates a new Commande entity.
     *
     * @Route("/customer/new/", name="customer_commande_new")
     * @Method({"POST"})
     */
    public function newCommandeAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }

        $user = $this->getUser();
        
        $username = $user->getUsername();
        $email = $user->getEmail();

        $commande = new Commande();
        $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $commande->setUser($user);
            $em->persist($commande);
            $em->flush();

            return new JsonResponse(array(
                'success' => true,
                'email' => $email
                
                )
           , 200);
        }
 
        $response = new JsonResponse(
                array(
            'message' => 'Error',
//            'form' => $this->renderView('AcmeDemoBundle:Demo:form.html.twig',
//                    array(
//                'entity' => $entity,
//                'form' => $form->createView(),
//            ))
            ), 400);

        return $response;


    }
    /**
     * Finds and displays a Vente entity.
     *
     * @Route("/{id}", name="vente_show")
     * @Method("GET")
     */
    public function showAction(Vente $vente)
    {
        $deleteForm = $this->createDeleteForm($vente);
        
        $commande = new Commande();
        $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
        
        return $this->render('vente/show.html.twig', array(
            'vente' => $vente,
            'delete_form' => $deleteForm->createView(),
            'form'=> $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Vente entity.
     *
     * @Route("/{id}/edit", name="vente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vente $vente)
    {
        $deleteForm = $this->createDeleteForm($vente);
        $editForm = $this->createForm('AppBundle\Form\VenteType', $vente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vente);
            $em->flush();

            return $this->redirectToRoute('vente_edit', array('id' => $vente->getId()));
        }

        return $this->render('vente/edit.html.twig', array(
            'vente' => $vente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Vente entity.
     *
     * @Route("/{id}", name="vente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vente $vente)
    {
        $form = $this->createDeleteForm($vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vente);
            $em->flush();
        }

        return $this->redirectToRoute('vente_index');
    }

    /**
     * Creates a form to delete a Vente entity.
     *
     * @param Vente $vente The Vente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vente $vente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vente_delete', array('id' => $vente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
    * @Route("/vente/provinces", name="vente_select_provinces")
    */
    public function provincesAction(Request $request)
    {
        $country_id = $request->request->get('country_id');

        $em = $this->getDoctrine()->getManager();
        $provinces = $em->getRepository('AppBundle:Province')->findByCountryId($country_id);

        return new JsonResponse($provinces);
    }

    /**
    * @Route("/vente/cities", name="vente_select_cities")
    */
    
    public function citiesAction(Request $request)
    {
        $province_id = $request->request->get('province_id');

        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('AppBundle:City')->findByProvinceId($province_id);

        return new JsonResponse($cities);
    }
    
    
    /**
     * Deletes a Vente entity.
     *
     * @Route("/v/search", name="vente_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $request->get('query');

        if(!$query) {
            if(!$request->isXmlHttpRequest()) {
                return $this->redirect($this->generateUrl('vente_index'));
            } else {
                return new JsonResponse('No results.');
            }
        }        
 
        $ventes = $em->getRepository('AppBundle:Vente')->getForLuceneQuery($query);
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $ventes, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            24/*limit per page*/
        );
        
        if($request->isXmlHttpRequest()) {
            if('*' == $query || !$ventes || $query == '') {
                return new JsonResponse('No results.');
            }
            return $this->render('vente/searchAjax.html.twig', array(
                'pagination' => $pagination,
                'categories' => $categories
            ));
        
        }
        
        return $this->render('vente/search.html.twig', array(
            'pagination' => $pagination,
            'categories' => $categories
        ));
    }
    
    /**
     * Filter by (Category)
     *
     * @Route("/filter", name="vente_filter")
     * @Method("POST")
     */
    public function filterAction(Request $request)
    {
        $filter = $request->request->get('filter');
        $em = $this->getDoctrine()->getManager();
        $ventes = $em->getRepository('AppBundle:Vente')->getOffresByCategory($filter);
        
        if(!$ventes) {
            return new JsonResponse('No results.');
        }
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $ventes, 
            $request->query->getInt('page', 1)/*page number*/,
            24/*limit per page*/
        );

        return $this->render('vente/searchAjax.html.twig', array(
                'pagination' => $pagination
        ));
    }
}
