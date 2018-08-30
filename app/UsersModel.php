<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'user_id';
    protected $table = 'tbl_users';  
}
