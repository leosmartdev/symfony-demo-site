<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Roles;
use App\Repository\RolesRepository;


class User3Type extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // enable this type to accept a limited set of countries
                'allowed_countries' => null,
                'roles' => [],
            ])
        ;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $allowedCountries = $options['allowed_countries'];
        $roles = $options['roles'];
        $roleChoices = array();
        foreach($roles as $role) {
            if ($role->getNombreRole() == "ROLE_ADMIN") {
                continue;
            }
            $roleChoices[$role->getDescripcionRole()] = $role->getId();
        }
        $builder
            ->add(
                'email',
                null,
                array('label' => 'email', 'required' => true))
            ->add(
                'username',
                null,
                array('label' => 'username', 'required' => true))
            ->add(
                'surname',
                null,
                array('label' => 'surname', 'required' => true))
            ->add(
                'password',
                null,
                array('label' => 'password', 'required' => true))
            ->add(
                'activo_usu', HiddenType::class, [
                    'data' => 1,
                ])
            ->add('Roles', ChoiceType::class, [
                'label' => 'role',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'choices'  => $roleChoices,
            ])
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
