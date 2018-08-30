<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomingModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'doc_id';
    protected $table = 'tbl_incoming';  

}