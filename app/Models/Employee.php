<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use ModelTrait;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'employees';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    protected $identifiableAttribute = 'full_name';

    protected $appends = ['full_name'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByFullName', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $orderBy = 'asc';
            $builder->orderBy('last_name', $orderBy);
            $builder->orderBy('first_name', $orderBy);
            $builder->orderBy('middle_name', $orderBy);
        });
    }

    // revise operation
    public function identifiableName()
    {
        return $this->getFullNameAttribute();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function civilStatus()
    {
        return $this->belongsTo(CivilStatus::class);
    }

    public function employmentDetails()
    {
        return $this->hasMany(EmploymentDetail::class);
    }

    public function employeeShiftSchedules()
    {
        return $this->hasMany(EmployeeShiftSchedule::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function relations()
    {
        return $this->hasMany(Relation::class);
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
    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name} {$this->middle_name}";
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
