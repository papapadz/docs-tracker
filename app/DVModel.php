<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DVModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'dv_id';
    protected $table = 'tbl_billing_dv';

}
