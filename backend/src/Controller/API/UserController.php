<?php 

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Entity\User;



class UserController extends AbstractController
{

    /**
     * @Route("/api/me" , methods={"GET"})
     * 
     *  @OA\Response(
     *     response=200,
     *     description="Returns user information",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class))
     *     )
     * )
     **/
    public function me()
    {
        if (!$this->getUser() or ($this->getUser() and !in_array('ROLE_ADMIN',$this->getUser()->getRoles()))) {
            throw $this->createAccessDeniedException();
        }
        return $this->json($this->getUser());
    }
}