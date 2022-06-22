<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = 'employer';

    protected $fillable = [
        'name', 'email', 'password','pic_path','mobile_number','landline_number',
        'address', 'city','state','country','company_logo','email_token','email_varified','employer_chat_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
