<?php

namespace models;

require_once 'CountryService.php';

class   CountryServiceImplementation implements CountryService
{
    private $apiUrl = 'https://countriesnow.space/api/v0.1/countries';

    public function getAllCountries(): array
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

            $response = curl_exec($ch);

            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                throw new Exception("cURL error: $error");
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode !== 200) {
                curl_close($ch);
            }

            curl_close($ch);

            $data = json_decode($response, true);

            if ($data === null || !isset($data['data']) || !is_array($data['data'])) {

            }

            $nationalities = [];
            foreach ($data['data'] as $countryData) {
                if (isset($countryData['country'])) {
                    $nationalities[] = $countryData['country'];
                }
            }

            sort($nationalities);

            return $nationalities;
        } catch (Exception $e) {
            return [
                "United States",
                "Canada",
                "United Kingdom",
                "Australia",
                "Germany",
                "France",
                "Brazil",
                "India",
                "China",
                "Japan"
            ];
        }
    }
}

?>