<?php

namespace App\UserInterface\Controller\Question;

use App\UserInterface\Presenter\Question\ListingPresenter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\CodeChallenge\Domain\Quiz\Request\ListingRequest;
use TBoileau\CodeChallenge\Domain\Quiz\UseCase\Listing;
use Twig\Environment;

/**
 * Class ListingController
 * @package App\UserInterface\Controller\Question
 */
class ListingController
{
    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * ListingController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     * @param Listing $listing
     * @return Response
     */
    public function __invoke(Request $request, Listing $listing): Response
    {
        $presenter = new ListingPresenter();

        $listing->execute(
            new ListingRequest(
                $request->get("page", 1),
                $request->get("limit", 10),
                $request->get("field", "title"),
                $request->get("order", "asc")
            ),
            $presenter
        );

        return new Response($this->twig->render("question/listing.html.twig", [
            "vm" => $presenter->getViewModel()
        ]));
    }
}
