<?php

namespace Irman\Exchange\Services;

use Exception;
use SimpleXMLElement;

class Exchange
{
    public const API_URL = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

    protected float $amount;
    private string $currency;
    /**
     * @var array<string, float>
     */
    private array $rates = [];

    /**
     * @throws Exception
     */
    public function __construct(float $amount, string $currency = 'EUR')
    {
        $this->amount = $amount;
        $this->currency = $currency;

        $this->initializeData();
    }

    /**
     * @throws Exception
     */
    protected function initializeData(): void
    {
        $rates = cache('exchange.rates');
        if(!$rates){
            $rates = $this->fetchAndCacheRates();
        }

        $this->rates = $rates;
    }

    public function to(string $currency): float|int|null
    {
        if($this->currency === $currency){
            return $this->amount;
        }

        $rate = $this->getRate($currency);
        if($rate){
            return $this->amount * $rate;
        }

        return null;
    }

    public function getRate(string $destinationCurrency): ?float
    {
        if($this->currency === $destinationCurrency){
            return 1.00;
        }

        if(isset($this->rates[$destinationCurrency])){
            return $this->rates[$destinationCurrency];
        }

        return null;
    }

    /**
     * @throws Exception
     * @return array<string, float>|null
     */
    protected function fetchAndCacheRates(): ?array
    {
        $data = $this->fetchData();
        $rates = [];
        foreach ($data->children() as $child) {
            $rates[(string) $child->attributes()->currency] = floatval($child->attributes()->rate);
        }
        config(['exchange.rates' => $rates], now()->endOfDay());

        return $rates;
    }

    protected function fetchData(): ?SimpleXMLElement
    {
        $ch = curl_init(self::API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($ch);

        if (is_bool($data) && $data === false) {
            try {
                $data = file_get_contents(self::API_URL);
            } catch (Exception $exception) {
                return null;
            }
        }

        return (new SimpleXMLElement($data))->Cube[0]->Cube[0];
    }
}
