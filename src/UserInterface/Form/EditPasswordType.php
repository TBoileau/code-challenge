<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\EditPassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class EditPasswordType
 * @package App\UserInterface\Form
 */
class EditPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("plainPassword", RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => [
                    "label" => "Nouveau mot de passe :",
                    "help" => "Votre mot de passe doit contenir au minimum 8 caractères."
                ],
                "second_options" => [
                    "label" => "Confirmez votre mot de passe :",
                    "help" => "Saisissez de nouveau votre mot de passe."
                ],
                "invalid_message" => "La confirmation doit être similaire au mot de passe",
                "constraints" => [
                    new NotBlank(),
                    new Length(["min" => 8, 'minMessage' => 'Le mot de passe doit contenir au moins 8 caractères.'])
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", EditPassword::class);
    }
}
