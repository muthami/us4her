<?php

namespace App\Observers;

use App\Models\DonationItem;
use App\Models\Inventory;

class DonationItemObserver
{
    /**
     * Handle the DonationItem "created" event.
     */
    public function created(DonationItem $donationItem): void
    {
        $donationItem->inventory()->save(new Inventory([
            'item_id' => $donationItem->item_id,
            'quantity' => $donationItem->quantity,
        ]));
    }

    /**
     * Handle the DonationItem "updated" event.
     */
    public function updated(DonationItem $donationItem): void
    {
        $inventory = $donationItem->inventory;

        if ($inventory) {
            // If the item_id has changed, delete old inventory and create a new one
            if ($inventory->item_id !== $donationItem->item_id) {
                $inventory->delete();

                $donationItem->inventory()->save(new Inventory([
                    'item_id' => $donationItem->item_id,
                    'quantity' => $donationItem->quantity,
                ]));
            } else {
                $inventory->update([
                    'quantity' => $donationItem->quantity,
                ]);
            }
        } else {
            $donationItem->inventory()->save(new Inventory([
                'item_id' => $donationItem->item_id,
                'quantity' => $donationItem->quantity,
            ]));
        }
    }

    /**
     * Handle the DonationItem "deleted" event.
     */
    public function deleted(DonationItem $donationItem): void
    {
        //
    }

    /**
     * Handle the DonationItem "restored" event.
     */
    public function restored(DonationItem $donationItem): void
    {
        //
    }

    /**
     * Handle the DonationItem "force deleted" event.
     */
    public function forceDeleted(DonationItem $donationItem): void
    {
        //
    }
}
