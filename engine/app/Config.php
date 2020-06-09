<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /*
     * Validations
     */
    public static function rules($update = false, $id = null)
    {
        $rules = [
            'header'    => 'required',
            'footer'    => 'required',
        ];

        return $rules;
    }
}
