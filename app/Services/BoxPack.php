<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class BoxPack
{
    private array $boxes = [];
    private array $items = [];

    public function setBoxes(array $boxConfigurations)
    {
        $this->boxes = array_map(function ($config) {
            return new BoxContainer(
                $config['name'],
                $config['length'],
                $config['width'],
                $config['height'],
                $config['weight_limit']
            );
        }, $boxConfigurations);
    }

    public function addItem(Items $items): void
    {
        $this->items[] = $items;
    }

    public function pack(): array
    {
        $packedBoxes = [];
        $packedItems = [];
        $remainingItems = $this->items;

        while (!empty($remainingItems)) {
            $box = $this->findSmallestSuitableBox($remainingItems);
            if ($box === null) {

                // If no suitable box is found, pack the largest items separately
                $largestItems = $this->findLargestItems($remainingItems);
                $boxForLargestItems = $this->findSmallestSuitableBox([$largestItems]);

                // Totality to show in the box
                $totalVolume = $largestItems->calculateTotalVolume();
                $totalWeight = $largestItems->weight * $largestItems->quantity;

                $packedBoxes[] = [
                    'box' => $boxForLargestItems,
                    'items' => [$largestItems],
                    'totalVolume' => $totalVolume,
                    'totalWeight' => $totalWeight,
                    'boxError' => null,
                ];

                if ($boxForLargestItems === null) {
                    throw new \Exception('No suitable box found for the largest items: ' . json_encode($largestItems));
                }

                // Reduce the list to the list of an item that doesnt have a box yet
                $remainingItems = array_filter($remainingItems, function ($items) use ($largestItems) {
                    return $items !== $largestItems;
                });
            } else {
                $packedItems = $this->packItemsIntoBox($box, $remainingItems);

                // Totality to show in the box
                $totalVolume = array_sum(array_map(function ($item) {
                    return $item->calculateTotalVolume();
                }, $packedItems));
    
                $totalWeight = array_sum(array_map(function ($item) {
                    return $item->weight * $item->quantity;
                }, $packedItems));

                $packedBoxes[] = [
                    'box' => $box,
                    'items' => $packedItems,
                    'totalVolume' => $totalVolume,
                    'totalWeight' => $totalWeight,
                    'boxError' => null,
                ];

                // Reduce the list to the list of an item that doesnt have a box yet
                $remainingItems = array_filter($remainingItems, function ($remainingItem) use ($packedItems) {
                    foreach ($packedItems as $packedItem) {
                        if ($this->compareItems($remainingItem, $packedItem)) {
                            return false;
                        }
                    }
                    return true;
                });
            }
        }

        return $packedBoxes;
    }

    /* Check and validate the smallet good box for all the items */
    private function findSmallestSuitableBox(array $items): ?BoxContainer
    {
        $totalVolume = array_sum(array_map(function ($items) {
            return $items->calculateTotalVolume();
        }, $items));

        $totalWeight = array_sum(array_map(function ($items) {
            return $items->weight * $items->quantity;
        }, $items));

        $suitableBoxes = array_filter($this->boxes, function ($box) use ($totalVolume, $totalWeight, $items) {
            return $box->calculateVolume() >= $totalVolume &&
                $box->weightLimit >= $totalWeight &&
                $this->canFitAllDimensions($box, $items);
        });

      
        if (empty($suitableBoxes)) {
            return null;
        }

        usort($suitableBoxes, function ($a, $b) {
            return $a->calculateVolume() - $b->calculateVolume();
        });

        return $suitableBoxes[0];
    }

    private function canFitAllDimensions(BoxContainer $box, array $items): bool
    {
        foreach ($items as $items) {
            if ($items->length > $box->length || $items->width > $box->width || $items->height > $box->height) {
                return false;
            }
        }
        return true;
    }

    /* Filter and search for largest item based on volume */
    private function findLargestItems(array $items): Items
    {
        usort($items, function ($a, $b) {
            return $b->calculateVolume() - $a->calculateVolume();
        });

        return $items[0];
    }

    /* Add computed items in the box */
    private function packItemsIntoBox(BoxContainer $box, array $items): array
    {
        $packedItems = [];
        $remainingVolume = $box->calculateVolume();
        $remainingWeight = $box->weightLimit;

        foreach ($items as $items) {
            if ($items->calculateTotalVolume() <= $remainingVolume &&
                $items->weight <= $remainingWeight &&
                $this->canFitDimensions($box, $items)
            ) {
                $packedItems[] = $items;
                $remainingVolume -= $items->calculateTotalVolume();
                $remainingWeight -= $items->weight;
            }
        }

        return $packedItems;
    }

    /* Validate item dimension vs box dimension */
    private function canFitDimensions(BoxContainer $box, Items $items): bool
    {
        return $items->length <= $box->length &&
            $items->width <= $box->width &&
            $items->height <= $box->height;
    }

    /* Comparitor for item array */
    private function compareItems($item1, $item2)
    {
        return $item1->name === $item2->name &&
            $item1->length === $item2->length &&
            $item1->width === $item2->width &&
            $item1->height === $item2->height &&
            $item1->weight === $item2->weight &&
            $item1->quantity === $item2->quantity;
    }
}