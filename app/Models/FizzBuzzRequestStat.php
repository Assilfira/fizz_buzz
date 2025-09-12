<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FizzBuzzRequestStat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fizzbuzz_request_stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['int1', 'int2', 'limit', 'str1', 'str2', 'hits'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
