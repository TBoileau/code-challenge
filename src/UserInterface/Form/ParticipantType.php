<?php

namespace App\UserInterface\Form;

use App\UserInterface\DataTransferObject\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('email', EmailType::class, ['label' => 'Email :'])
          ->add('pseudo', TextType::class, ['label' => 'Pseudo :'])
          ->add('avatarPath', FileType::class, ['label' => 'Choisir un avatar :', 'required' => false])
        ;

        $builder->get('avatarPath')->addModelTransformer(new CallbackTransformer(
            fn ($avatarPath) => null,
            fn ($avatarPath) => $avatarPath,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Participant::class);
    }
}
