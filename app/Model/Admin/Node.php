<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $table='bs_nodes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'uses','relates','sort'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
    
}
