<?php

namespace App\Controller;

use AbstractBaseController;
use App\Entity\Products;
use App\Security\Validations;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractBaseController
{

    /**
     * @Route("/products", name="get_products_all_business", methods={"GET", "OPTIONS"})
     */
    public function getAll(): JsonResponse
    {
        try {
            if(Validations::checkToken()) return $this->responseTokenInvalid();

            $allProducts = $this->entityManager->getRepository(Products::class)->findAll();
            $allProducts = $allProducts ? $this->normalize($allProducts) : [];
            return new JsonResponse([
                'message' => 'Products list',
                'products' => $allProducts
            ], 200);
        } catch (\Exception $e) {
            return $this->ExceptionResponse($e);
        }
    }

    /**
     * @Route("/products", name="create_product", methods={"POST", "OPTIONS"})
     */
    public function createProduct(Request $request): JsonResponse
    {
        try {
            if(Validations::checkToken()) return $this->responseTokenInvalid();

            $parameters = $request->getContent();
            $products_array = json_decode($parameters, true);

            $allProducts = [];
            foreach ($products_array as $productData) {
                $product = new Products();
                $product->setSku($productData['sku']);
                $product->setProductName($productData['product_name']);
                $product->setDescription($productData['description']);
                $product->setCreatedAt(new \DateTime());
                $product->setUpdatedAt(new \DateTime());
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $allProducts[] = $this->normalize($product);
            }

            return new JsonResponse([
                'message' => 'Added products',
                'data' => $allProducts
            ], 201);
        } catch (\Exception $e) {
            return $this->ExceptionResponse($e);
        }
    }

    /**
     * @Route("/products", name="update_product", methods={"PUT", "OPTIONS"})
     */
    public function updateProduct(Request $request): JsonResponse
    {
        try {
            if(Validations::checkToken()) return $this->responseTokenInvalid();
            
            $parameters = $request->getContent();
            $products_array = json_decode($parameters, true);

            $allProducts = [];
            foreach ($products_array as $key => $productData) {
                $product = $this->entityManager
                    ->getRepository(Products::class)
                    ->findOneBy(['id' => $productData['id']]);
                $product->setSku($productData['sku']);
                $product->setProductName($productData['product_name']);
                $product->setDescription($productData['description']);
                $product->setUpdatedAt(new \DateTime());
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $allProducts[] = $this->normalize($product);
            }

            return new JsonResponse([
                'message' => 'Productos actualizados',
                'data' => $allProducts
            ], 201);
        } catch (\Exception $e) {
            return $this->ExceptionResponse($e);
        }
    }
}
