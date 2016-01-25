<?php

namespace App\Models;

use Baum\Node;

class Organization extends Node
{
    protected  $fillable    = ['name','parent_id'];
    protected $guarded      = array('id', 'left', 'right', 'depth');

    // 'parent_id' column name
    protected $parentColumn = 'parent_id';

    // 'lft' column name
    protected $leftColumn = 'left';

    // 'rgt' column name
    protected $rightColumn = 'right';

    // 'depth' column name
    protected $depthColumn = 'depth';

    /**
     * @param $value
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getIdAttribute($value)
    {
        return (int) $value;
    }

    /**
     * @param $value
     * @return int
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function getParentIdAttribute($value)
    {
        return (int) $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function parent()
    {
        return $this->belongsTo(Organization::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Organization::class, 'parent_id');
    }
}