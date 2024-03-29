<?php 

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{

    /**
     * @Route("/api/me")
     **/
    public function me()
    {
        if (!$this->getUser() or ($this->getUser() and !in_array('ROLE_ADMIN',$this->getUser()->getRoles()))) {
            throw $this->createAccessDeniedException();
        }
        return $this->json($this->getUser());
    }
}