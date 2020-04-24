<?php

namespace App\UserInterface\Form;

use App\Infrastructure\Validator\NonUniqueEmail;
use App\Infrastructure\Validator\NonUniquePseudo;
use App\UserInterface\DataTransferObject\Registration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationType
 * @package App\UserInterface\Form
 */
class RegistrationType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                "label" => "Email :",
                "constraints" => [
                    new NotBlank(),
                    new Email(),
                    new NonUniqueEmail()
                ]
            ])
            ->add("pseudo", TextType::class, [
                "label" => "Pseudo :",
                "constraints" => [
                    new NotBlank(),
                    new NonUniquePseudo()
                ]
            ])
            ->add("plainPassword", RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => [
                    "label" => "Mot de passe :"
                ],
                "second_options" => [
                    "label" => "Confirmez votre mot de passe :"
                ],
                "invalid_message" => "La confirmation doit être similaire au mot de passe",
                "constraints" => [
                    new NotBlank(),
                    new Length(["min" => 8])
                ]
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", Registration::class);
    }
}
