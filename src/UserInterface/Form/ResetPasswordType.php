<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\ResetPasswordData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ResetPasswordType
 * @package App\UserInterface\Form
 */
class ResetPasswordType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("email", EmailType::class, [
                "label" => "Email :",
                "constraints" => [
                    new NotBlank(),
                    new Email()
                ],
                "help" => "Veuillez saisir une adresse email valide, ex: xyz@email.com."
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class", ResetPasswordData::class);
    }
}
