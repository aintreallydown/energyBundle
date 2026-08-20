<?php

namespace aintreallydown\EnergyBundle\Form;

use App\Form\PropertyFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use aintreallydown\ContractTypeBundle\Service\EnergyBundleService;

class PropertyFormTypeExtension extends AbstractTypeExtension
{
    public function __construct(
        private EnergyBundleService $energyBundleService,
    ) {}

    public static function getExtendedTypes(): iterable
    {
        return [PropertyFormType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $energyChoices = $this->energyBundleService->getEnergyChoices($options['country'] ?? null);

        $property = $builder->getData();
        $currentEnergy = $property?->getExtrafields()['energy'] ?? null;

        $builder->add('energy', ChoiceType::class, [
            'mapped' => false,
            'choices' => $energyChoices,
            'data' => $currentEnergy,
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'country' => null,
        ]);
        $resolver->setAllowedTypes('country', ['string', 'null']);
    }
}
