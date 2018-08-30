<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'check_id';
    protected $table = 'tbl_billing_check';

}
