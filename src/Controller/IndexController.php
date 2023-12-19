<?php
namespace App\Controller;

use App\Contracts\AbstractBaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractBaseController
{

    /**
     * @Route("/test", name="index", methods={"GET", "OPTIONS"})
     */
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'message' => "Welcome to AaxisTest API",
            'data' => []
        ], 200);
    }

}
