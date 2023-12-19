<?php
namespace App\Contracts;
use App\Services\Logger;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractBaseController extends AbstractController
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    protected function normalize($object): array
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        return $serializer->normalize($object);
    }

    protected function ExceptionResponse(Exception $exception): JsonResponse
    {
        Logger::error($exception);
        if (getenv('APP_ENV') != 'Prod') {
            return new JsonResponse([
                'message'   => $exception->getMessage(),
                'data' => []
            ], 500);
        }

        return new JsonResponse([
            'message'   => 'Server Error',
            'data' => []
        ], 500);
    }

    protected function responseTokenInvalid(): JsonResponse
    {
        return new JsonResponse([
            'message'   => 'Token is invalid',
            'data' => []
        ], 401);
    }
}
