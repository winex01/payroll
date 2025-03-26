<?php

namespace App\Models;

use App\Traits\HelperTrait;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class EmploymentDetailType extends Model
{
    use ModelTrait;
    use HelperTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'employment_detail_types';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByReorder', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->orderBy('lft', 'asc');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function employmentDetails()
    {
        return $this->hasMany(EmploymentDetail::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getFormattedNameAttribute()
    {
        return $this->strToHumanReadable($this->name);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
