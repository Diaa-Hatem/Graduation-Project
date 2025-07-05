<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Child extends Model
{
    use HasFactory,HasApiTokens;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'children';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';


    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    ##--------------------------------- RELATIONSHIPS
    public function category_scores()
    {
        return $this->hasMany(Category_Score::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
