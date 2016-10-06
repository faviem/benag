<?php

namespace Ben\WebServiceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;


/**
 * @Rest\RouteResource("Vente")
 */
class VenteController extends Controller
{
    /**
     * Récupération des projects de l'utilisateur connecté
     * [GET] /offres
     *
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     * 
     * ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     * @param string $page
     * @Rest\View()
     * @Cache(smaxage="600", public="true")
     */
    public function cgetAction()
    {

//        $offres = $this->getDoctrine()
//        ->getRepository('AppBundle:Vente')
//        ->findByPage();
//
//        $view = $this->view($offres, 200);
////        $view->setFormat('jsonp');
//        return $this->handleView($view);
        
//        $user = $this->container->get('security.context')->getToken()->getUser();
//        if (!is_object($user) || !$user instanceof UserInterface) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//        $mappingSortedby = array(
//            'date' => 'createDate',
//            'price' => 'price',
//            'name' => 'publicName',
//            'author' => 'owner',
//        );
//
//        $sortColumn = null;
//        if ($sortedby) {
//            $sortColumn = $mappingSortedby[$sortedby];
//        }
//        
//        $maxTemplates = $this->container->getParameter('max_offres_per_page');
//        $offres_count = $this->getDoctrine()
//                ->getRepository('AppBundle:Vente')
//                ->getCountVente();
//        
//        $pagination = array(
//            'page' => $page,
//            'route' => 'get_ventes',
//            'pages_count' => ceil($offres_count / $maxTemplates),
//            'route_params' => array()
//        );

//        if ($category) {
//            $offres = $this->get('project_manager')->findProjectTemplatesByCategory(
//                $category, $maxTemplates, $page - 1, $sortColumn
//            );
//        } else {
//            $offres = $this->get('project_manager')->findProjectTemplates(
//                $maxTemplates, $page - 1, $sortColumn
//            );
//        }
        
        $offres = $this->getDoctrine()
        ->getRepository('AppBundle:Vente')
//         ->findByPage($maxTemplates, $page);
         ->findAll();       
        
        $aResponses = array();
        foreach ($offres as $offre) {
            $aResponses[] = array(
                'id' => $offre->getId(),
                'lieu' => $offre->getLieu(),
                'image' => $offre->getImageName(),
                'product' =>$offre->getProduct()->getName(),
                'prix' => $offre->getPrixUnit()
            );
        }
        // return url for view the preview
        $aResult = [
            'code' => 'OK',
            'messages' => '',
            'pagination' => $pagination,
            'offres' => $aResponses,
        ];

        return new JsonResponse ($aResult);      
    }

}
