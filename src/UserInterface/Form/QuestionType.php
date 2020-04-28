<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

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
                "entry_type" => TextType::class,
                "entry_options" => [
                    "label" => false,
                    'attr' => [
                        "placeholder" => "Votre réponse..."
                    ],
                    "constraints" => [
                        new NotBlank()
                    ]
                ],
                "allow_add" => true,
                "allow_delete" => true,
                "constraints" => [
                    new Valid(),
                    new Count(["min" => 2])
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
