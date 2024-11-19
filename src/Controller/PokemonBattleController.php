<?php

declare(strict_types=1);    

namespace App\Controller;

use App\DTO\PokemonBattleInput;
use App\Service\PokemonBattleService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class PokemonBattleController
{
    public function __construct(
        private PokemonBattleService $battleService,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,

    ) {}

    public function __invoke(#[MapRequestPayload] PokemonBattleInput $data): JsonResponse
    {
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }
        
        try {
            $result = $this->battleService->simulateBattle($data->pokemon1, $data->pokemon2);

            return new JsonResponse($result, JsonResponse::HTTP_OK);
        } catch (\RuntimeException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}