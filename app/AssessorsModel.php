<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessorsModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'assessor_id';
    protected $table = 'tbl_assessors';

}
