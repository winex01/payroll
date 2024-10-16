<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use ModelTraits;
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

    // Magic method to dynamically retrieve properties
    public function __get($key)
    {
        // Attempt to find the latest employment detail for the requested key
        $detail = $this->getEmploymentDetailByType($key);

        if (!$detail) {
            return null;
        }

        // Check if the type corresponds to a relational model
        if (class_exists($detail->type)) {
            // Return the related model instance using the value as the ID
            $type = $detail->type;
            return $type::find($detail->value);
        }

        // If not relational, return the direct value
        return $detail->value;
    }

    // Retrieve employment detail by type
    public function getEmploymentDetailByType($type)
    {
        return $this->employmentDetails()
            ->active()
            ->where('type', $type)
            ->orderBy('effectivity_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
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

    public function families()
    {
        return $this->hasMany(Family::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
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
