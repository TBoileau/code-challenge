<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\Answer;
use App\UserInterface\DataTransferObject\Question;
use Assert\Assertion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class QuestionType
 * @package App\UserInterface\Form
 */
class QuestionType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                "label" => "Titre de la question",
                "constraints" => [
                    new NotBlank()
                ]
            ])
            ->add("answers", CollectionType::class, [
                "label" => "Liste des réponses",
                "entry_type" => AnswerType::class,
                "allow_add" => true,
                "allow_delete" => true,
                "constraints" => [
                    new Valid(),
                    new Count(["min" => 2]),
                    new Callback(["callback" => function ($values, ExecutionContextInterface $context) {
                        $goodAnswers = array_filter(
                            $values,
                            fn (Answer $answer) => $answer->isGood()
                        );

                        if (count($goodAnswers) < 1) {
                            $context
                                ->buildViolation('Vous devez sélectionner au moins une bonne réponse.')
                                ->addViolation()
                            ;
                        }
                    }])
                ]
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Question::class);
    }
}
