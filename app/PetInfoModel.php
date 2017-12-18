<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetInfoModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'pet_id';
    protected $table = 'tbl_pets';  
}