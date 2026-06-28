<?php

namespace App\Form;

use App\Entity\Crm\User;
use App\Enum\UserRole;
use App\Enum\UserStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserType extends AbstractType
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['disabled' => $options['edit_mode']])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => !$options['edit_mode'],
                'label' => 'Password',
            ])
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Administrator' => (string) UserRole::Administrator->value,
                    'Employee' => (string) UserRole::Employee->value,
                    'Customer' => (string) UserRole::Customer->value,
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Active' => UserStatus::Active->value,
                    'Suspended' => UserStatus::Suspended->value,
                ],
            ])
            ->add('firstName', TextType::class, ['required' => false])
            ->add('lastName', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => false])
            ->add('telephone', TextType::class, ['required' => false])
            ->add('cellphone', TextType::class, ['required' => false])
            ->add('producer', TextType::class, ['required' => false])
            ->add('stateId', TextType::class, ['required' => false, 'label' => 'Customer ID']);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event): void {
            $user = $event->getData();
            if (!$user instanceof User) {
                return;
            }

            $plainPassword = $event->getForm()->get('plainPassword')->getData();
            if (is_string($plainPassword) && $plainPassword !== '') {
                $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'edit_mode' => false,
        ]);
    }
}
