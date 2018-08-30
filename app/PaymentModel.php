<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'payment_id';
    protected $table = 'tbl_billing_payment';

}
