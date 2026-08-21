<?php

namespace aintreallydown\EnergyBundle\Service;

use App\Entity\EnergyValue;
use Doctrine\ORM\EntityManagerInterface;

class EnergyBundleService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function getEnergyChoices(): array
    {
        $energyValues = $this->entityManager->getRepository(EnergyValue::class)->findBy(
            ['isEnergy' => true],
            ['value' => 'ASC']
        );

        $choices = [];
        foreach ($energyValues as $energyValue) {

            $choices[$energyValue->getLabel()] = $energyValue->getValue();
        }

        return $choices;
    }

    public function getEmissionChoices(): array
    {
        $emissionValues = $this->entityManager->getRepository(EnergyValue::class)->findBy(
            ['isEmission' => true],
            ['value' => 'ASC']
        );

        $choices = [];
        foreach ($emissionValues as $emissionValue) {
            $choices[$emissionValue->getLabel()] = $emissionValue->getValue();
        }


        return $choices;
    }
}
