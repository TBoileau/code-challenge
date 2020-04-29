<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class AnswerType
 * @package App\UserInterface\Form
 */
class AnswerType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("good", CheckboxType::class, [
                "required" => false
            ])
            ->add("title", TextType::class, [
                "label" => false,
                'attr' => [
                    "placeholder" => "Votre réponse..."
                ],
                "constraints" => [
                    new NotBlank()
                ]
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Answer::class);
    }
}
