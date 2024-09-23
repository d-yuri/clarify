<?php

namespace App\Form;

use App\Entity\CarrierPriceRule;
use App\Config\CarrierPricingTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;

class CarrierPriceRuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EnumType::class, [
                'class'=>CarrierPricingTypes::class,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('weightLimit', IntegerType::class, [
                'required' => false,
            ])
            ->add('fixedPrice', NumberType::class, [
                'required' => false,
            ])
            ->add('pricePerKg', NumberType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarrierPriceRule::class,
            'csrf_protection' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): ?string
    {
        return '';
    }
}