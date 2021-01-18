<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'class';
    // protected $primaryKey = 'longname';

    // public function namespaces() {
    //     return $this->hasManyThrough(Namespaces::class, 'memberof', 'longname');
    // }


    // public function namespace() {
        //     return $this->belongsTo(Namespaces::class, 'memberof', 'longname');
        // }
    // Get all parameters from a class
    public function params() {
        return $this->hasMany(Param::class, "parentClass", "longname")->where('parentFunction', '');
    }

    public function extends() {
        return $this->hasMany(Extend::class, "class", "longname");
    }

    // Members
    public function membersConstants() {
        return $this->hasMany(Constant::class, 'memberof', 'longname');
    }

    public function members() {
        return $this->hasMany(Member::class, "memberOf", "longname");
    }

    public function functions() {
        return $this->hasMany(Functions::class, "memberof", "longname");
    }
}