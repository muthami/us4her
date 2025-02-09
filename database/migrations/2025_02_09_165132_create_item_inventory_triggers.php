<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateItemInventoryTriggers extends Migration
{
    private function triggers()
    {
        return ['insert', 'update', 'delete'];
    }

    public function up()
    {
        foreach ($this->triggers() as $trigger) {
            DB::unprepared($this->sql($trigger));
        }
    }

    private function getTriggerName($trigger)
    {
        $suffix = ($trigger === 'delete' ? '_on_delete' : ($trigger === 'update' ? '_on_update' : '_on_insert'));
        return "get_balances$suffix";
    }

    public function sql($trigger)
    {
        $table = ($trigger === 'delete' ? 'OLD' : 'NEW');
        $trigger_name = $this->getTriggerName($trigger);

        return "
        CREATE TRIGGER " . $trigger_name . "
        AFTER  " . $trigger . " ON inventories FOR EACH ROW
        BEGIN
            SET @distributions = (SELECT SUM(quantity) FROM inventories
                WHERE inventories.inventoryable_type = 'distribution'
                AND inventories.item_id = " . $table . ".item_id);

            SET @donations = (SELECT SUM(quantity) FROM inventories
                WHERE inventories.inventoryable_type = 'donation'
                AND inventories.item_id = " . $table . ".item_id);

            IF @distributions IS NULL THEN SET @distributions = 0; END IF;
            IF @donations IS NULL THEN SET @donations = 0; END IF;

            SET @inventory = (@donations - @distributions);
            UPDATE items SET inventory = @inventory WHERE id = " . $table . ".item_id;
        END";
    }

    public function down()
    {
        foreach ($this->triggers() as $trigger) {
            $trigger_name = $this->getTriggerName($trigger);
            DB::unprepared("DROP TRIGGER $trigger_name");
        }
    }

}
