<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TasksModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'task_id';
    protected $table = 'tbl_tasks';
}
