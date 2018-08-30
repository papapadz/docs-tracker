<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConcernedStaffModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'cs_id';
    protected $table = 'tbl_concerned_staff';

}
