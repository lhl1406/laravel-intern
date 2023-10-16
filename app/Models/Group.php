<?php

namespace App\Models;

use App\Traits\ObservantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $table = 'group';
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'note',
        'group_leader_id',
        'group_floor_number',
        'created_date',
        'updated_date',
        'deleted_date',
    ];

    /**
     * Get the user for the group.
     */
    public function users(): HasMany {
        return $this->hasMany(User::class);
    }
}
