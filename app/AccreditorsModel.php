<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccreditorsModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'accreditor_id';
    protected $table = 'tbl_accreditors';

}
