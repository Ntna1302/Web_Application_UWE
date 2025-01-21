<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vnpay extends Model
{

    protected $table = 'tbl_vnpay'; // Table name
    protected $fillable = [
        'vnp_amount',
        'vnp_bankcode',
        'vnp_banktranno',
        'vnp_cardtype',
        'vnp_orderInfo',
        'vnp_paydate',
        'vnp_tmnCode',
        'vnp_transactionno',
        'vnp_txnref',
        'vnp_status',
    ];
    public $timestamps = false; // Disable automatic timestamps    
}
