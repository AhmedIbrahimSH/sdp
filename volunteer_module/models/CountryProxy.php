<?php

namespace models;

require_once 'CountryService.php';
require_once 'CountryServiceImplementation.php';

class CountryProxy implements CountryService
{
    private $realSubject = null;
    private $cacheFile = 'countries_cache.json';
    private $cacheDuration = 600;

    public function getAllCountries(): array
    {
        if ($this->isCacheValid()) {
            return $this->loadFromCache();
        }

        try {
            if ($this->realSubject === null) {
                $this->realSubject = new CountryServiceImplementation();
            }

            $nationalities = $this->realSubject->getAllCountries();

            $this->saveToCache($nationalities);

            return $nationalities;
        } catch (Exception $e) {
            error_log("Failed to fetch countries from API: " . $e->getMessage());

            if (file_exists($this->cacheFile)) {
                return $this->loadFromCache();
            }

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

    private function isCacheValid(): bool
    {
        return file_exists($this->cacheFile) && (time() - filemtime($this->cacheFile) < $this->cacheDuration);
    }
    private function loadFromCache(): array
    {
        $cacheContent = file_get_contents($this->cacheFile);
        return json_decode($cacheContent, true);
    }

    private function saveToCache(array $nationalities): void
    {
        file_put_contents($this->cacheFile, json_encode($nationalities));
    }
}

?>