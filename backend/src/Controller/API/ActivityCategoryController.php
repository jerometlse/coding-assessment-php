<?php

namespace App\Controller\API;

use App\Entity\ActivityCategory;
use App\Repository\ActivityCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/api/activityCategory", name = "api.activityCategory.")
 */
class ActivityCategoryController extends AbstractController
{
    
    /**
     * @Route(name = "index", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the list of leisure bases",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ActivityCategory::class, groups={"activityCategory_index"}))
     *     )
     * )
     * @OA\Tag(name="ActivityCategory")
     */
     
    public function index(Request $request, EntityManagerInterface $em, ActivityCategoryRepository $activityCategoryRepository){
        $activityCategories = $activityCategoryRepository->findAll();   
       

        return $this->json($activityCategories,200, [], ["groups"=> ["activityCategory_index"]]);
    }

}