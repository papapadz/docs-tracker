<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramRegistrationModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'pr_id';
    protected $table = 'tbl_program_registration';

}
