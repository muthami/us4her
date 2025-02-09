<?php

namespace App\Observers;

use App\Models\DistributionItem;
use App\Models\Inventory;

class DistributionItemObserver
{
    /**
     * Handle the DistributionItem "created" event.
     */
    public function created(DistributionItem $distributionItem): void
    {
        $distributionItem->inventory()->save(new Inventory([
            'item_id' => $distributionItem->item_id,
            'quantity' => $distributionItem->quantity,
        ]));
    }

    /**
     * Handle the DistributionItem "updated" event.
     */
    public function updated(DistributionItem $distributionItem)
    {
        $inventory = $distributionItem->inventory; // Use the relationship

        if ($inventory) {
            // If the item_id has changed, delete old inventory and create a new one
            if ($inventory->item_id !== $distributionItem->item_id) {
                $inventory->delete();

                // Create a new inventory entry linked to the updated DistributionItem
                $distributionItem->inventory()->save(new Inventory([
                    'item_id' => $distributionItem->item_id,
                    'quantity' => $distributionItem->quantity,
                ]));
            } else {
                $inventory->update([
                    'quantity' => $distributionItem->quantity,
                ]);
            }
        } else {
            $distributionItem->inventory()->save(new Inventory([
                'item_id' => $distributionItem->item_id,
                'quantity' => $distributionItem->quantity,
            ]));
        }
    }


    /**
     * Handle the DistributionItem "deleted" event.
     */
    public function deleted(DistributionItem $distributionItem): void
    {
        //
    }

    /**
     * Handle the DistributionItem "restored" event.
     */
    public function restored(DistributionItem $distributionItem): void
    {
        //
    }

    /**
     * Handle the DistributionItem "force deleted" event.
     */
    public function forceDeleted(DistributionItem $distributionItem): void
    {
        //
    }
}
