<?php

namespace App\Services;

use App\Enums\DataProviders;
use App\Enums\DataProviderXStatuses;
use App\Enums\DataProviderYStatuses;
use JsonMachine\Items;

class ParentsService
{

    public function getParentsAccounts($filters): array
    {
        $jsonFilesName = [DataProviders::DATA_PROVIDER_X_FILE_NAME, DataProviders::DATA_PROVIDER_Y_FILE_NAME];
        if (isset($filters['provider'])) {
            $filters['provider'] == DataProviders::DATA_PROVIDER_X ? $jsonFilesName = [DataProviders::DATA_PROVIDER_X_FILE_NAME] : $jsonFilesName = [DataProviders::DATA_PROVIDER_Y_FILE_NAME];
        }
        $parents = [];
        foreach ($jsonFilesName as $jsonFileName) {
            $fileIndex = 0;
            $fileItems = Items::fromFile('data/' . $jsonFileName);
            foreach ($fileItems as $item) {
                if ($fileIndex >= $filters['offset']) {
                    if ($fileIndex > ($filters['offset'] + $filters['limit'])) {
                        break;
                    }
                    if (!$this->itemMatchFilters($filters, $item, $jsonFileName))
                       continue;


                    $parents[] = $item;
                }
                $fileIndex++;
            }
        }
        return $parents;
    }

    private function itemMatchFilters($filters, $item, $jsonFileName): bool
    {

        if ($jsonFileName == DataProviders::DATA_PROVIDER_X_FILE_NAME) {

            if (isset($filters['statusCode']) && $item->statusCode != DataProviderXStatuses::getStatusEquivalentInteger($filters['statusCode']))
                return false;

            if (isset($filters['currency']) && $item->Currency != $filters['currency'])
                return false;

            if (isset($filters['balanceMin']) && $filters['balanceMin'] > $item->parentAmount)
                return false;

            if (isset($filters['balanceMax']) && $filters['balanceMax'] < $item->parentAmount)
                return false;
        } else {

            if (isset($filters['statusCode']) && $item->status != DataProviderYStatuses::getStatusEquivalentInteger($filters['statusCode']))
                return false;

            if (isset($filters['currency']) && $item->currency != $filters['currency'])
                return false;

            if (isset($filters['balanceMin']) && $filters['balanceMin'] > $item->balance)
                return false;

            if (isset($filters['balanceMax']) && $item->balance < $filters['balanceMax'])
                return false;
        }
        return true;
    }
}
