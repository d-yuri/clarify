<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Form\CarrierType;
use App\Repository\CarrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/carrier')]
final class CarrierController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route(name: 'app_carrier_list', methods: ['GET'])]
    public function index(CarrierRepository $carrierRepository): Response
    {
        $data = $this->serializer->serialize($carrierRepository->findAll(), 'json', ['groups' => 'carrier:list']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/new', name: 'app_carrier_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $carrier = new Carrier();
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carrier);
            $entityManager->flush();

            $data = $this->serializer->serialize($carrier, 'json', ['groups' => 'carrier:new']);

            return new JsonResponse($data, Response::HTTP_CREATED, [], true);
        }

        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
    }
}
