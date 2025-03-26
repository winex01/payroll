<?php

namespace App\Traits;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait ModelTraits
{
    use CrudTrait;
    use HasFactory;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    /*
        This is used when the value (old or new) is the id of a foreign key relationship.
        By default, it simply returns the ID of the model that was updated. It is up to
        you to override this method in your own models to return something meaningful.
    */
    public function identifiableName()
    {
        return $this->name;
    }
}
