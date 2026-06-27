<?php

namespace App\Form;

use App\Entity\Crm\StaffProfile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['disabled' => $options['edit_mode']])
            ->add('firstName', TextType::class, ['required' => false])
            ->add('lastName', TextType::class, ['required' => false])
            ->add('email', EmailType::class)
            ->add('telephone', TextType::class, ['required' => false])
            ->add('cellphone', TextType::class, ['required' => false])
            ->add('producer', TextType::class, ['required' => false])
            ->add('stateId', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StaffProfile::class,
            'edit_mode' => false,
        ]);
    }
}
