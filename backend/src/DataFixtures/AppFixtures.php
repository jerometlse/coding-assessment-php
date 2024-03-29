<?php

namespace App\DataFixtures;

use App\Entity\ActivityCategory;
use App\Entity\LeisureBase;
use App\Utils\MapboxService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppFixtures extends Fixture
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    
    public function load(ObjectManager $manager): void
    {
        $mapboxService = new MapboxService( $this->params->get('mapbox'));
        
        // insert activity categories
        $categrories = ['Kitesurf', 'Canoë', 'Wakeboard', 'Accrobranche'];
        $categroriesFixtures = [];
        foreach ($categrories as $category) 
        {
            $activityCategory = new ActivityCategory();
            $activityCategory->setLabel($category);
            $manager->persist($activityCategory);
            $categroriesFixtures[$category] = $activityCategory;
        }


        //****************** */
        // insert leisure bases
        $leisureBase = new LeisureBase();
        $leisureBase->setName('La ramée')
                ->setDescription('base nautique')
                ->setLink('https://www.laramee.fr')
                ->setAddress('51 Chem. de Larramet, 31170 Tournefeuille France')
                ->addActivityCategory($categroriesFixtures['Canoë'])
                ->addActivityCategory($categroriesFixtures['Wakeboard']);
        
        // Get longitude and latitude
        $coordinates = $mapboxService->getAddressLatitudeAndLongitude($leisureBase->getAddress());        
        $leisureBase->setLongitude($coordinates['longitude']);
        $leisureBase->setLatitude($coordinates['latitude']);        
        $manager->persist($leisureBase);

        $leisureBase = new LeisureBase();
        $leisureBase->setName('natura game')
                ->setDescription('base multi sports')
                ->setLink('https://www.natura-game.fr')
                ->setAddress('1 Rte de Gragnague, 31180 Castelmaurou France')
                ->addActivityCategory($categroriesFixtures['Accrobranche']);
        
        // Get longitude and latitude
        $coordinates = $mapboxService->getAddressLatitudeAndLongitude($leisureBase->getAddress());        
        $leisureBase->setLongitude($coordinates['longitude']);
        $leisureBase->setLatitude($coordinates['latitude']);        
        $manager->persist($leisureBase);

        $leisureBase = new LeisureBase();
        $leisureBase->setName('WAM PARK')
                ->setDescription('base nautique')
                ->setLink('https://www.wampark.fr/toulouse-sesquieres')
                ->setAddress('All. des Foulques, 31200 Toulouse')
                ->addActivityCategory($categroriesFixtures['Wakeboard']);
        
        // Get longitude and latitude
        $coordinates = $mapboxService->getAddressLatitudeAndLongitude($leisureBase->getAddress());        
        $leisureBase->setLongitude($coordinates['longitude']);
        $leisureBase->setLatitude($coordinates['latitude']);        
        $manager->persist($leisureBase);
        
        $leisureBase = new LeisureBase();
        $leisureBase->setName('Coriolis Foil School')
                ->setDescription('base nautique')
                ->setLink('https://coriolisfoilschool.fr')
                ->setAddress('SPOT DU GOULET, 11370 Leucate 31200 Toulouse')
                ->addActivityCategory($categroriesFixtures['Kitesurf']);
        
        // Get longitude and latitude
        $coordinates = $mapboxService->getAddressLatitudeAndLongitude($leisureBase->getAddress());        
        $leisureBase->setLongitude($coordinates['longitude']);
        $leisureBase->setLatitude($coordinates['latitude']);        
        $manager->persist($leisureBase);


        $manager->flush();
    }
}
