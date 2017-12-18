<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DogBoardingModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'board_id';
    protected $table = 'tbl_dogboardlist';
}
