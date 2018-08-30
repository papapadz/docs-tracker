<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OriginsModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'origin_id';
    protected $table = 'tbl_origins';

}
