<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryRequestsModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'inventoryreq_id';
    protected $table = 'tbl_inventoryreq';
}
