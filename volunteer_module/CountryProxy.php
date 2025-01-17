<?php
// app/proxies/CountryProxy.php

require_once 'CountryService.php';
require_once 'CountryServiceImplementation.php';

class CountryProxy implements CountryService
{
    private $realSubject = null;
    private $cacheFile = 'countries_cache.json'; // Path to the cache file
    private $cacheDuration = 600; // Cache duration in seconds (10 minutes)

    public function getAllCountries(): array
    {
        // Check if the cache file exists and is not older than 10 minutes
        if ($this->isCacheValid()) {
            // Load countries from the cache file
            return $this->loadFromCache();
        }

        // If the cache is invalid, fetch countries from the API
        try {
            // Lazy initialization: Create the RealSubject only when needed
            if ($this->realSubject === null) {
                $this->realSubject = new CountryServiceImplementation();
            }

            // Fetch countries from the API
            $nationalities = $this->realSubject->getAllCountries();

            // Save the fetched countries to the cache file
            $this->saveToCache($nationalities);

            return $nationalities;
        } catch (Exception $e) {
            // Log the error
            error_log("Failed to fetch countries from API: " . $e->getMessage());

            // If the API fails, try to load from the cache (even if it's old)
            if (file_exists($this->cacheFile)) {
                return $this->loadFromCache();
            }

            // If no cache exists, return a default list of countries
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

    /**
     * Check if the cache is valid (exists and is not older than 10 minutes).
     */
    private function isCacheValid(): bool
    {
        return file_exists($this->cacheFile) && (time() - filemtime($this->cacheFile) < $this->cacheDuration);
    }

    /**
     * Load countries from the cache file.
     */
    private function loadFromCache(): array
    {
        $cacheContent = file_get_contents($this->cacheFile);
        return json_decode($cacheContent, true);
    }

    /**
     * Save countries to the cache file.
     */
    private function saveToCache(array $nationalities): void
    {
        file_put_contents($this->cacheFile, json_encode($nationalities));
    }
}
?>