<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientsModel extends Model
{	
	public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'client_type_id';
    protected $table = 'tbl_client_types';  

}
