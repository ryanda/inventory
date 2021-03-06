<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    protected $table = 'Receivable';
    protected $fillable = [];
    protected $hidden = [];

    protected $dates = ['created_at', 'updated_at', 'due_date'];

    protected static $clientModel = 'App\Models\Client';
    protected static $salesModel = 'App\Models\Sales';

    public function client () {
        return $this->belongsTo(static::$clientModel, 'client_id');
    }

    public function sales () {
        return $this->belongsTo(static::$salesModel, 'sales_id');
    }
}