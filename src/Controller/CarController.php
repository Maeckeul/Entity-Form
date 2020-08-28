<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/", name="car_browse")
     */
    public function browse(CarRepository $carRepository)
    {
        return $this->render('car/browse.html.twig', [
            'cars' => $carRepository->findAll()
        ]);
    }

    /**
     * @Route("/car/add", name="car_add", methods={"GET", "POST"})
     */
    public function add(Request $request)
    {
        $car = new Car();

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($car);
            $manager->flush();

            return $this->redirectToRoute('car_browse');
        }

        return $this->render('car/add.html.twig', [
            'car' => $car,
            'form' => $form->createView()
        ]);
    }
}
