<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CountryType;


class User3Type extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // enable this type to accept a limited set of countries
                'allowed_countries' => null,
            ])
        ;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $allowedCountries = $options['allowed_countries'];
        $builder
            ->add(
                'name',
                null,
                array('label' => 'name', 'required' => true))
            ->add(
                'surname',
                null,
                array('label' => 'surname', 'required' => true))
            ->add(
                'username',
                null,
                array('label' => 'username', 'required' => true))
            ->add(
                'email',
                null,
                array('label' => 'email', 'required' => true))
            ->add(
                'password',
                null,
                array('label' => 'password', 'required' => false))
            ->add('Roles', ChoiceType::class, [
                'label' => 'role',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => [
                    'Partner' => 'ROLE_CONTROLLER',
                    'User' => 'ROLE_USER',
                ],
            ])
            ->add(
                'add_user',
                null,
                array('label' => 'add_user', 'required' => true))
            ->add(
                'update_user',
                null,
                array('label' => 'update_user', 'required' => true))
            ->add('create_at')
            ->add('update_at')
                ->add('country',
                    CountryType::class, [
                    'required' => true,
                    'label' => 'country',
                    'choice_filter' => $allowedCountries ? function ($countryCode) use ($allowedCountries) {
                        return in_array($countryCode, $allowedCountries, true);
                    } : null,

            ])
        ;
        $builder->get('Roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
        ));
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => User::class,
    //     ]);
    // }
}
