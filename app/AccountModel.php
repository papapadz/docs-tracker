<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'account_id';
    protected $table = 'tbl_accounts';  
}
