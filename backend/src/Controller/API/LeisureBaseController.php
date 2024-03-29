<?php

namespace App\Controller\API;

use App\Entity\LeisureBase;
use App\Repository\ActivityCategoryRepository;
use App\Repository\LeisureBaseRepository;
use App\Utils\MapboxService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @Route("/api/leisureBase", name = "api.leisureBase.")
 */
class LeisureBaseController extends AbstractController
{
    /**
     * @Route(name = "index", methods={"GET"})
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page number",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Number of result per page",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="category",
     *     in="query",
     *     description="Activity category name",
     *     @OA\Schema(type="string")
     * )
     *  @OA\Parameter(
     *     name="description",
     *     in="query",
     *     description="Leisure base description",
     *     @OA\Schema(type="string")
     * )
     *  @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="leisure base name",
     *     @OA\Schema(type="string")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns the list of leisure bases",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=LeisureBase::class, groups={"leisureBase_index"}))
     *     )
     * )
     * @OA\Tag(name="LeisureBase")
     */
    public function index(Request $request, LeisureBaseRepository $leisureBaseRepository)
    {
        $name = $request->query->get("name");
        $description = $request->query->get("description");
        $category = $request->query->get("category");
        $page = $request->query->getInt("page", 1);
        $limit = $request->query->getInt("limit", 10);

        $leisureBases = $leisureBaseRepository->findByNameDescriptionOrActivityCategory($page, $limit, $name, $description, $category); 

        // TODO get wether for each leisure bases

        return $this->json($leisureBases,200,[],  ["groups"=> ["leisureBase_index"]]);
    }


    /**
     * @Route(name="create", methods={"POST"})
     * 
     * @OA\Response(
     *     response=200,
     *     description="Returns created leisure base",
     *     @OA\JsonContent(
     *        ref=@Model(type=LeisureBase::class, groups={"leisureBase_index"})
     *     )
     * )
     * @OA\Tag(name="LeisureBase")
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ActivityCategoryRepository $activityCategoryRepository)
    { 
        //TODO secure ENDPOINT

        $leisureBase = new LeisureBase();
        $leisureBase = $serializer->deserialize($request->getContent(), LeisureBase::class,"json",[
                AbstractNormalizer::OBJECT_TO_POPULATE => $leisureBase,
                "groups" => ["leisurebase_create"]
        ]);

        // TODO find how to use serialier ?
        if ($activityCategories=json_decode($request->getContent())->activityCategories){
            foreach( $activityCategories as $activityCategory){
                $activityCategory = $activityCategoryRepository->find($activityCategory->id);
                if ($activityCategory){
                    $leisureBase->addActivityCategory($activityCategory);
                }
            }
        }

        // Get longitude and latitude
        $mapboxService = new MapboxService($this->getParameter('mapbox'));
        $coordinates = $mapboxService->getAddressLatitudeAndLongitude($leisureBase->getAddress());        
        $leisureBase->setLongitude($coordinates['longitude']);
        $leisureBase->setLatitude($coordinates['latitude']);

        $em->persist($leisureBase);
        $em->flush();

        return $this->json([$leisureBase], 200, [], [
            "groups" => ["leisureBase_index"]
        ]);
    }

    /**
     * @Route("/{id}" , name = "delete", methods={"DELETE"}, requirements={"id"="\d+"})
     *  @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="leisure base id",
     *     @OA\Schema(type="integer")
     * )
     *  @OA\Response(
     *     response=200,
     *     description="Deletion succeed",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="LeisureBase")
     */
    public function remove(int $id, LeisureBaseRepository $leisureBaseRepository, EntityManagerInterface $em)
    {
        //TODO secure ENDPOINT 
        $leisureBase = $leisureBaseRepository->find($id);
        $em->remove($leisureBase);
        $em->flush();

        return $this->json(["status" => "success"], 200, []);
    }

    /**
     * @Route(name = "update", methods={"PUT","PUSH"})
     */
    public function update(LeisureBase $request, EntityManagerInterface $em)
    {
        //TODO 
    }
}