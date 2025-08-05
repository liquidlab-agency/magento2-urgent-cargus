<?php

declare(strict_types=1);

namespace Urgent\Base\Model\Helper;

use Urgent\Base\Model\Api\GetIntlCountries;

class IntlCountryId
{
    private array $countryCurrencyMapper = [
        'Romania' => 'RON',
        'Grecia' => 'EUR',
        'Bulgaria' => 'BGN',
        'Polonia' => 'PLN',
    ];

    /**
     * @var GetIntlCountries
     */
    private GetIntlCountries $getIntlCountries;

    /**
     * @param GetIntlCountries $getIntlCountries
     */
    public function __construct(
        GetIntlCountries $getIntlCountries
    ) {
        $this->getIntlCountries = $getIntlCountries;
    }

    /**
     * @param $currency
     */
    public function getIntlCountryIdByCurrency($currency)
    {
        $intlCountries = $this->getIntlCountries->execute();
        $countryName = array_search($currency, $this->countryCurrencyMapper);
        if ($countryName === false) {
            return null;
        }

        foreach ($intlCountries as $country) {
            if ($country['name'] === $countryName) {
                return $country['id'];
            }
        }
        return null;
    }

}
