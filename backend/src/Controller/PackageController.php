<?php

namespace App\Controller;

use App\Entity\Package;
use App\Form\DTO\CreatePackageDTO;
use App\Form\PackageType;
use App\Repository\PackageRepository;
use App\Service\CarrierCalculator;
use App\Service\PackageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/package')]
final class PackageController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route(name: 'app_package_list', methods: ['GET'])]
    public function index(PackageRepository $packageRepository): JsonResponse
    {
        $data = $this->serializer->serialize($packageRepository->findAll(), 'json', ['groups' => 'package:list']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/new', name: 'app_package_new', methods: ['POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        PackageService $packageService
    ): JsonResponse {
        $createPackageDTO = new CreatePackageDTO();
        $form = $this->createForm(PackageType::class, $createPackageDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $package = $packageService->createPackage($createPackageDTO);
            } catch (\Throwable $e) {
                return new JsonResponse(['errors' => ['message' => 'Error on create']], Response::HTTP_BAD_REQUEST);
            }

            $data = $this->serializer->serialize($package, 'json', ['groups' => 'package:new']);

            return new JsonResponse($data, Response::HTTP_CREATED, [], true);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return new JsonResponse(['errors' => $errors], Response::HTTP_BAD_REQUEST);
    }
}
