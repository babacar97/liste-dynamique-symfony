<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'query_builder ' => function (CountryRepository $countryRepository) {
                    return $countryRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                }
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'query_builder ' => function (CityRepository $cityRepository) {
                    return $cityRepository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                }
            ])
            ->add('message', TextareaType::class)
            ->getForm();

        return $this->renderForm('home.html.twig', Compact('form'));
    }
}
