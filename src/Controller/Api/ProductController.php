<?php

namespace App\Controller\Api;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/api/products/{id}', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $json_content = $serializer->serialize($product, 'json');
 
        return JsonResponse::fromJsonString($json_content);
    }

    #[Route('/api/products', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $data = $request->getContent();
        $product = $serializer->deserialize($data, Product::class, 'json');
        $em->persist($product);
        $em->flush();

        return $this->json($product, 201);
    }

    #[Route('/api/products/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $data = $request->getContent();
        $serializer->deserialize($data, Product::class, 'json', ['object_to_populate' => $product]);
        $em->flush();   
        return $this->json($product);
    }

    #[Route('/api/products/{id}', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $product = $em->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        $em->remove($product);
        $em->flush();
        return $this->json(null, 204);
    }
}
