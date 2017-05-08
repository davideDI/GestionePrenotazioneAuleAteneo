<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'tip_user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    //Relazione con la tabella tip_user
    public function tipUser() {
        return $this->belongsTo('App\TipUser');
    }
    
    //Relazione con la tabella bookings
    public function bookings() {
        return $this->hasMany('App\Booking');
    }
    
    //Relazione con la tabella surveys
    public function surveys() {
        return $this->hasMany('App\Survey');
    }
    
    //Relazione con la tabella groups
    public function groups() {
        return $this->hasMany('App\Group');
    }
    
}
