<?php


namespace App\Models\Automata;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;

abstract class Model extends EloquentModel
{
    protected $connection = 'detectenv';
    protected $primaryKey = null;
    public $timestamps = false;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return $this->primaryKey ?? "id_{$this->getTable()}";
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table ?? Str::snake(class_basename($this));
    }

}
