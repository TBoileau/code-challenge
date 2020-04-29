<?php

namespace App\UserInterface\Controller\Question;

use App\UserInterface\DataTransferObject\Answer;
use App\UserInterface\DataTransferObject\Question;
use App\UserInterface\Form\QuestionType;
use App\UserInterface\Presenter\Question\UpdatePresenter;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question as DomainQuestion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use TBoileau\CodeChallenge\Domain\Quiz\Request\UpdateRequest;
use TBoileau\CodeChallenge\Domain\Quiz\UseCase\Update;
use Twig\Environment;

/**
 * Class UpdateController
 * @package App\UserInterface\Controller\Question
 */
class UpdateController
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
     * UpdateController constructor.
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
     * @param DomainQuestion $domainQuestion
     * @param Request $request
     * @param Update $create
     * @param UpdatePresenter $presenter
     * @return RedirectResponse|Response
     * @throws \Assert\AssertionFailedException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(
        DomainQuestion $domainQuestion,
        Request $request,
        Update $create,
        UpdatePresenter $presenter
    ) {
        $question = Question::fromDomainQuestion($domainQuestion);
        $form = $this->formFactory->create(QuestionType::class, $question)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $request = UpdateRequest::create(
                $domainQuestion->getId(),
                $question->getTitle(),
                array_map(
                    fn (Answer $answer) => ["title" => $answer->getTitle(), "good" => $answer->isGood()],
                    $question->getAnswers()
                )
            );
            $create->execute($request, $presenter);

            return new RedirectResponse($this->urlGenerator->generate("home"));
        }

        return new Response($this->twig->render("question/update.html.twig", [
            "form" => $form->createView()
        ]));
    }
}
