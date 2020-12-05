<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\RecoverPasswordData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RecoverPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("newPlainPassword", RepeatedType::class, [
                "type" => PasswordType::class,
                "first_options" => [
                    "label" => "Mot de passe :",
                    "help" => "Votre mot de passe doit contenir au minimum 8 caractères."
                ],
                "second_options" => [
                    "label" => "Confirmez votre mot de passe :",
                    "help" => "Saisissez de nouveau votre mot de passe."
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", RecoverPasswordData::class);
    }
}
