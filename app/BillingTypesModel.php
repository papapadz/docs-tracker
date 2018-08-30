<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingTypesModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'billing_type_id';
    protected $table = 'tbl_billing_types';

}
