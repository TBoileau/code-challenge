<?php

namespace App\UserInterface\Controller;

use App\UserInterface\Presenter\BarPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\Bar;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarPresenterInterface;
use TBoileau\CodeChallenge\Domain\Foo\UseCase\BarRequest;

/**
 * Class BarController
 * @package App\UserInterface\Controller
 */
class BarController
{
    /**
     * @param int $id
     * @param Bar $bar
     * @param BarPresenter $presenter
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function __invoke(
        int $id,
        Bar $bar,
        BarPresenter $presenter,
        SerializerInterface $serializer
    ): JsonResponse {
        $bar->execute(new BarRequest($id), $presenter);

        return new JsonResponse(
            $serializer->serialize($presenter->getViewModel(), 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json'],
            true
        );
    }
}
