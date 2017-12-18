<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrescriptionModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'prescription_id';
    protected $table = 'tbl_prescriptions';  
}