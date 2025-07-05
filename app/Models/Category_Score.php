<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Score extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_scores';


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
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
