<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    public $timestamps = false;

    protected $fillable = [
    'ip_address','date_visitor'
];
    protected $primaryKey ='id_visitors';
    protected $table ='tbl_visitors';
    
}