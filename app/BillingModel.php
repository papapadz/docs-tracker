<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'billing_id';
    protected $table = 'tbl_billing';

}
