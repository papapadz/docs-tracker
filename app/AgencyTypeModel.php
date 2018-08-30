<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyTypeModel extends Model
{
	public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'agency_type_id';
    protected $table = 'tbl_agency_types';

}
