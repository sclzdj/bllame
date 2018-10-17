<?php

namespace App\Model\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $table='bs_admins';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password','nickname','access_type','status'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    
    public function roles(){
        return $this->belongsToMany(Role::class,'bs_personates','bs_admin_id','bs_role_id');
    }
    
    public function nodes(){
        return $this->belongsToMany(Node::class,'bs_belongs','bs_admin_id','bs_node_id');
    }
}
