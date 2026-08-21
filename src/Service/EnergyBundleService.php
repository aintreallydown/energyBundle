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
            [],
            ['value' => 'ASC']
        );

        $choices = [];

        foreach ($energyValues as $energyValue) {

            $choices[$energyValue->getValue()] = [
                'labelMin' => $energyValue->getLabelMin(),
                'labelMax' => $energyValue->getLabelMax(),
            ];
        }


        return $choices;
    }
}
