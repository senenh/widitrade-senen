<?php

namespace App\Controller;

use App\DTO\UrlData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlShortenerController extends AbstractController
{
    #[Route('/url-shortener', name: 'app_url_shortener', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $urlData = $serializer->deserialize($request->getContent(), UrlData::class, 'json');

        $errors = $validator->validate($urlData);

        if (count($errors) > 0) {
            return $this->jsonErrors($errors);
        }
        
        // TODO: Implement the URL shortening logic
        
        return new JsonResponse(['url' => $urlData->getUrl()]);
    }

    private function jsonErrors(ConstraintViolationListInterface $errors): JsonResponse
    {
        $errorMessages = [];

        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return new JsonResponse([
            'errors' => $errorMessages,
        ], JsonResponse::HTTP_BAD_REQUEST);
    }
}
