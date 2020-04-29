<?php

namespace App\Infrastructure\ParamConverter;

use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use TBoileau\CodeChallenge\Domain\Quiz\Entity\Question;
use TBoileau\CodeChallenge\Domain\Quiz\Gateway\QuestionGateway;

/**
 * Class QuestionConverter
 * @package App\Infrastructure\ParamConverter
 */
class QuestionConverter implements ParamConverterInterface
{
    /**
     * @var QuestionGateway
     */
    private QuestionGateway $questionGateway;

    /**
     * QuestionConverter constructor.
     * @param QuestionGateway $questionGateway
     */
    public function __construct(QuestionGateway $questionGateway)
    {
        $this->questionGateway = $questionGateway;
    }

    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $request->attributes->set(
            "domainQuestion",
            $this->questionGateway->getQuestionById(Uuid::fromString($request->get("id")))
        );
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Question::class;
    }
}
