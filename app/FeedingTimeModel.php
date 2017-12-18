<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedingTimeModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'ft_id';
    protected $table = 'tbl_feedingtime';  
}