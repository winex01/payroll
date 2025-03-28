<?php

namespace App\Models;

use App\Traits\ModelTrait;
use App\Facades\HelperFacade;
use Illuminate\Database\Eloquent\Model;

class EmploymentDetailType extends Model
{
    use ModelTrait;

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
        return HelperFacade::strToHumanReadable($this->name);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
