<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    use SoftDeletes;
    
    protected $table = 'students';

    public static $gradeLevel = [
        1 => '1',
        2 => '2',       
        3 => '3',       
        4 => '4',                     
        5 => '5',                     
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
    ];
}
