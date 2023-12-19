<?php

namespace App\Controller;

use App\Contracts\AbstractBaseController;
use App\Entity\Products;
use App\Security\Validations;
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
            if (Validations::checkToken()) return $this->responseTokenInvalid();

            $allProducts = $this->entityManager->getRepository(Products::class)->findAll();
            $allProducts = $allProducts ? $this->normalize($allProducts) : [];
            return new JsonResponse([
                'message' => 'Products list',
                'data' => $allProducts
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
            if (Validations::checkToken()) return $this->responseTokenInvalid();

            $parameters = $request->getContent();
            $products_array = json_decode($parameters, true);

            # Basic Validations of Json
            if (!is_array($products_array) || count($products_array) < 1) return new JsonResponse([
                'message' => 'Data provided in incorrect format',
                'data' => []
            ], 400);

            $allProducts = [];
            $Errors = [];
            foreach ($products_array as $productData) {

                # We validate required values
                $validate = !isset($productData['sku']);
                $validate = !isset($productData['product_name']) || $validate;
                $validate = !isset($productData['description']) || $validate;
                if ($validate) {
                    $Errors['message'] = "Incorrect data or format in the following products";
                    $Errors['products'][] = $productData;
                    continue;
                }

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
                'data' => $allProducts,
                'errors' => $Errors
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
            if (Validations::checkToken()) return $this->responseTokenInvalid();

            $parameters = $request->getContent();
            $products_array = json_decode($parameters, true);

            # Basic Validations of Json
            if (!is_array($products_array) || count($products_array) < 1) return new JsonResponse([
                'message' => 'Data provided in incorrect format',
                'data' => []
            ], 400);

            $allProducts = [];
            $Errors = [];
            foreach ($products_array as $productData) {

                # We validate required values
                $validate = !isset($productData['sku']);
                $validate = !isset($productData['product_name']) || $validate;
                $validate = !isset($productData['description']) || $validate;
                if ($validate) {
                    $Errors['message'] = "Incorrect data or format in the following products";
                    $Errors['products'][] = $productData;
                    continue;
                }

                $product = $this->entityManager
                    ->getRepository(Products::class)
                    ->findOneBy(['sku' => $productData['sku']]);
                # If product is not found
                if (!$product) {
                    $Errors['message'] = "Incorrect data or format in the following products";
                    $Errors['products'][] = [
                        'info' => "Product not found",
                        'data' => $productData
                    ];
                    continue;
                }
                $product->setSku($productData['sku']);
                $product->setProductName($productData['product_name']);
                $product->setDescription($productData['description']);
                $product->setUpdatedAt(new \DateTime());
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $allProducts[] = $this->normalize($product);
            }

            return new JsonResponse([
                'message' => 'Updated products',
                'data' => $allProducts,
                'errors' => $Errors
            ], 201);
        } catch (\Exception $e) {
            return $this->ExceptionResponse($e);
        }
    }
}
