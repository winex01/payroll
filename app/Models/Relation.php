<?php

namespace App\Models;

use App\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\EmployeeNotSoftDeletedScope;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([EmployeeNotSoftDeletedScope::class])]
class Relation extends Model
{
    use ModelTraits;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'relations';
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function relationable(): MorphTo
    {
        return $this->morphTo();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function relationship()
    {
        return $this->belongsTo(Relationship::class);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
