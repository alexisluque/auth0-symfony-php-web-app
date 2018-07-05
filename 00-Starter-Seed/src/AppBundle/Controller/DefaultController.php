<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $port = $this->container->get('router')->getContext()->getHttpPort();
        if (!empty($port)) {
            $port = ':'.$port;
        }
        $returnTo = sprintf('%s://%s%s/auth0/logout',
            $this->container->get('router')->getContext()->getScheme(),
            $this->container->get('router')->getContext()->getHost(),
            $port);
        $logoutUrl = sprintf(
            'https://%s/v2/logout?client_id=%s&returnTo=%s',
            getenv('AUTH0_DOMAIN'),
            getenv('AUTH0_CLIENT_ID'),
            $returnTo);
        return $this->render('default/index.html.twig', array(
            'logoutUrl' => $logoutUrl
        ));
    }
}
