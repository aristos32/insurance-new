<?php

namespace App\Form;

use App\Entity\Crm\Owner;
use App\Enum\OwnerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stateId', TextType::class, ['label' => 'State ID'])
            ->add('firstName', TextType::class, ['required' => false])
            ->add('lastName', TextType::class, ['required' => false])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Client' => OwnerType::Account,
                    'Lead' => OwnerType::Lead,
                ],
            ])
            ->add('proposerType', ChoiceType::class, [
                'choices' => ['Person' => 'PERSON', 'Company' => 'COMPANY'],
                'required' => false,
            ])
            ->add('email', EmailType::class, ['required' => false])
            ->add('telephone', TextType::class, ['required' => false])
            ->add('cellphone', TextType::class, ['required' => false])
            ->add('company', TextType::class, ['required' => false])
            ->add('profession', TextType::class, ['required' => false])
            ->add('countryOfBirth', TextType::class, ['required' => false])
            ->add('countryOfResidence', TextType::class, ['required' => false])
            ->add('birthDate', DateType::class, ['widget' => 'single_text', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Owner::class]);
    }
}
