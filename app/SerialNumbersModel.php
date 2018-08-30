<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerialNumbersModel extends Model
{
	public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'serial_id';
    protected $table = 'tbl_serial_no';

}
