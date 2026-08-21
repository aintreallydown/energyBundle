<?php

namespace aintreallydown\EnergyBundle\Service;

use App\Entity\EnergyValue;
use Doctrine\ORM\EntityManagerInterface;

class EnergyBundleService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function getEnergyChoices(string $country): array
    {
        $energyValues = $this->entityManager->getRepository(EnergyValue::class)->findBy(
            [],
            ['label' => 'ASC']
        );

        $choices = [];

        foreach ($energyValues as $energyValue) {

            $choices[$energyValue->getLabel()] =
                [
                    'valueMin' => $energyValue->getValueMin(),
                    'valueMax' => $energyValue->getValueMax(),
                ];
        }

        return $choices;
    }
}
