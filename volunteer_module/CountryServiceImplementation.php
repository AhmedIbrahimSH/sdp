<?php
// app/proxies/CountryServiceImplementation.php

require_once 'CountryService.php';

class   CountryServiceImplementation implements CountryService
{
    private $apiUrl = 'https://countriesnow.space/api/v0.1/countries';

    public function getAllCountries(): array
    {
        try {
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Increase timeout to 30 seconds
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            // Force cURL to use HTTP/1.1 instead of HTTP/2
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

            // Execute the request
            $response = curl_exec($ch);

            // Check for cURL errors
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                throw new Exception("cURL error: $error");
            }

            // Check HTTP status code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode !== 200) {
                curl_close($ch);
                throw new Exception("API request failed with HTTP code: $httpCode");
            }

            curl_close($ch);

            // Decode the JSON response
            $data = json_decode($response, true);

            // Check if the response is valid
            if ($data === null || !isset($data['data']) || !is_array($data['data'])) {
                throw new Exception("Invalid API response: " . json_last_error_msg());
            }

            // Extract country names from the response
            $nationalities = [];
            foreach ($data['data'] as $countryData) {
                if (isset($countryData['country'])) {
                    $nationalities[] = $countryData['country'];
                }
            }

            // Sort nationalities alphabetically
            sort($nationalities);

            return $nationalities;
        } catch (Exception $e) {
            // Log the error
            error_log("Failed to fetch countries from API: " . $e->getMessage());

            // Return a default list of countries
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