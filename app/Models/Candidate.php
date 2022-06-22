<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Candidate extends Model
{
    protected $table = 'candidates';
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'email_token','phone_number','landline_number','nationality',
        'dob','applied_for','experience_years','experience_months','availablefrom','usavisa_c1d',
        'competency_certificate','last_vassel_served','vassel_size','email_verified_at','candidate_status','availability_status','updated_at','candidate_chat_id','docs_uploaded',
    ];

}
