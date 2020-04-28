<?php

namespace App\UserInterface\Controller\Question;

use App\UserInterface\DataTransferObject\Question;
use App\UserInterface\Form\QuestionType;
use App\UserInterface\Presenter\Question\CreatePresenter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Request\CreateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\UseCase\Create;
use Twig\Environment;

/**
 * Class CreateController
 * @package App\UserInterface\Controller\Question
 */
class CreateController
{
    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * CreateController constructor.
     * @param FormFactoryInterface $formFactory
     * @param Environment $twig
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param Create $create
     * @return RedirectResponse|Response
     * @throws \Assert\AssertionFailedException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Request $request, Create $create)
    {
        $question = new Question();
        $form = $this->formFactory->create(QuestionType::class, $question)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $request = CreateRequest::create($question->getTitle(), $question->getAnswers());
            $create->execute($request, new CreatePresenter());

            return new RedirectResponse($this->urlGenerator->generate("home"));
        }

        return new Response($this->twig->render("question/create.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
