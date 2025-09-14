<?php

namespace App\Controller\Api;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class ProductController extends AbstractController
{
    #[Route('/api/products', methods: ['GET'])]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $products = $em->getRepository(Product::class)->findAll();
        $json_content = $serializer->serialize($products, 'json');

        // return $this->json($products);
        return JsonResponse::fromJsonString($json_content);
    }
}
