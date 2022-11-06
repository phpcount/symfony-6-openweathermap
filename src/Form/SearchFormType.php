<?php

namespace App\Form;

use App\Request\SearchRequest;
use App\Utils\WeatherUnitsMeasurement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'label' => 'Город',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Введите название города',
                ],
                'constraints' => new Length(min: 3),
            ])
            ->add('units', ChoiceType::class, [
                'label' => 'Меры измерения',
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => array_flip(WeatherUnitsMeasurement::UNITS),
                'data' => WeatherUnitsMeasurement::METRIC,
                'constraints' => new Length(min: 3),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchRequest::class,
        ]);
    }
}
