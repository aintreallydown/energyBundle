<?php

namespace aintreallydown\EnergyBundle\Form;

use App\Form\PropertyFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use aintreallydown\EnergyBundle\Service\EnergyBundleService;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

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
        $energyChoices = $this->energyBundleService->getEnergyChoices();

        $emissionChoices = $this->energyBundleService->getEmissionChoices();

        $property = $builder->getData();

        $currentEnergy = $property?->getExtrafields()['energy'] ?? null;
        $currentEmission = $property?->getExtrafields()['emission'] ?? null;

        $builder->add('energy', ChoiceType::class, [
            'mapped' => false,
            'choices' => $energyChoices,
            'data' => $currentEnergy,
            'expanded' => true,
        ]);

        if ($emissionChoices) {

            $builder->add('emission', ChoiceType::class, [
                'mapped' => false,
                'choices' => $emissionChoices,
                'data' => $currentEmission,
                'expanded' => true,
            ]);
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();

            $property = $form->getData();

            $extrafields = $property->getExtrafields() ?? [];
            $extrafields['energy'] = $form->get('energy')->getData();

            if ($form->has('emission')) {
                $extrafields['emission'] = $form->get('emission')->getData();
            }

            $property->setExtrafields($extrafields);
        });
    }
}
