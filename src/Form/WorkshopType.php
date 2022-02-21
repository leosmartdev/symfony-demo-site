<?php

namespace App\Form;

use App\Entity\Maestros;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Roles;
use App\Repository\RolesRepository;

class WorkshopType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                // enable this type to accept a limited set of countries
                'edit' => false,
            ])
        ;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $edit = $options['edit'];
        $builder
            ->add(
                'field1',
                null,
                array('label' => 'field1', 'required' => true))
            ->add(
                'field2',
                null,
                array('label' => 'field1', 'required' => true))
            ->add(
                'field3',
                null,
                array('label' => 'field1', 'required' => true))
            ->add(
                'deleted', HiddenType::class, [
                    'data' => 0,
                ]);
    }

}
