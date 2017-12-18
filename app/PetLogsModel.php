<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetLogsModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'log_id';
    protected $table = 'tbl_petlogs';
}
