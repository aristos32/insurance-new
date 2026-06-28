<?php

namespace App\Form;

use App\Entity\Crm\Customer;
use App\Enum\CustomerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stateId', TextType::class)
            ->add('firstName', TextType::class, ['required' => false])
            ->add('lastName', TextType::class, ['required' => false])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Customer' => CustomerType::Customer,
                    'Lead' => CustomerType::Lead,
                ],
            ])
            ->add('email', EmailType::class, ['required' => false])
            ->add('telephone', TextType::class, ['required' => false])
            ->add('cellphone', TextType::class, ['required' => false])
            ->add('company', TextType::class, ['required' => false])
            ->add('countryOfResidence', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Customer::class]);
    }
}
