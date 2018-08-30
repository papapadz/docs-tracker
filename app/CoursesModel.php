<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursesModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'course_id';
    protected $table = 'tbl_courses';

}
