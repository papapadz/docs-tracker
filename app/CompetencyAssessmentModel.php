<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencyAssessmentModel extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'cac_id';
    protected $table = 'tbl_competency_assessment_certification';

}
