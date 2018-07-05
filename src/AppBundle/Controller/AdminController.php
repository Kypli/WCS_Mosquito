<?php
/**
 * Created by PhpStorm.
 * User: matthieu
 * Date: 11/01/18
 * Time: 15:40
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function AdminAction()
    {
        return $this->render('default/admin.html.twig');
    }
}