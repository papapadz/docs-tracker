<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BreedsModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'breed_id';
    protected $table = 'tbl_breeds';  
}
