<?php

declare(strict_types=1);

namespace App\Weather\Ports\Http\Ui\Forms;

use App\Weather\Infrastructure\DataProviders\City\CityDataProviderInterface;
use App\Weather\Infrastructure\DataProviders\City\CityDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class CityFormType extends AbstractType
{

    public function __construct(private readonly CityDataProviderInterface $cityDataProvider)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', ChoiceType::class, [
                'label' => 'Select city',
                'choices' => $this->citiesChoices(),
            ]);
    }

    private function citiesChoices(): array
    {
        $cities = ["" => ""] + array_map(
            static fn(CityDTO $city): string => $city->name,
            $this->cityDataProvider->getCities()
        );

        return array_combine($cities, $cities);
    }
}