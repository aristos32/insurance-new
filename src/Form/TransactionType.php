<?php

namespace App\Form;

use App\Entity\Crm\Sale;
use App\Enum\TransactionDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sale', EntityType::class, [
                'class' => Sale::class,
                'choice_label' => 'saleId',
            ])
            ->add('details', ChoiceType::class, [
                'choices' => array_combine(
                    array_map(static fn (TransactionDetail $d): string => $d->value, TransactionDetail::cases()),
                    TransactionDetail::cases(),
                ),
            ])
            ->add('debit', NumberType::class, ['required' => false, 'scale' => 2])
            ->add('credit', NumberType::class, ['required' => false, 'scale' => 2])
            ->add('receiptNo', TextType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
