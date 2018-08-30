<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocTypesModel extends Model
{	
	public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'doctype_id';
    protected $table = 'tbl_doc_types';  

}