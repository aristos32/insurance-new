<?php

namespace App\Form;

use App\Entity\Crm\Customer;
use App\Entity\Crm\Sale;
use App\Enum\InsuranceType;
use App\Enum\SaleStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('saleId', TextType::class, ['label' => 'Contract No'])
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => fn (Customer $customer): string => $customer->getFullName() . ' (' . $customer->getStateId() . ')',
            ])
            ->add('company', TextType::class, ['required' => false])
            ->add('insuranceType', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(static fn (InsuranceType $t): string => $t->value, InsuranceType::cases()),
                    InsuranceType::cases(),
                ),
            ])
            ->add('coverageType', TextType::class, ['required' => false])
            ->add('startDate', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('endDate', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('associate', TextType::class, ['required' => false])
            ->add('producer', TextType::class, ['required' => false])
            ->add('status', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(static fn (SaleStatus $s): string => $s->value, SaleStatus::cases()),
                    SaleStatus::cases(),
                ),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Sale::class]);
    }
}
