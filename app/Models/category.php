<?php

namespace App\Models;



use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    // SoftDeletes
    use HasFactory ;

    protected $fillable = [
        'name', 'parent_id', 'description', 'image', 'status', 'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class , 'category_id' , 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class , 'parent_id' , 'id')->withDefault([
            'name' => 'No category name'
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class , 'parent_id' , 'id');
    }

    //protected $guarded= [];

    public function scopeActive(Builder $builder){
        $builder->where('status', '=' , 'active');
    }

    public function scopeFilter(Builder $builder , $filters){

        $builder->when($filters['name'] ?? false , function ($builder , $value){
            $builder->where('categories.name', 'LIKE' , '%' . $value . '%');
        });


        $builder->when($filters['status'] ?? false , function ($builder , $value){
            $builder->where('categories.status' , '=' ,   $value );
        });

        // if($filters['name'] ?? false){
        //     $builder->where('name', 'LIKE' , "%{$filters['name']}%");
        // }

        // if($filters['name'] ?? false){
        //     $builder->where('status', '=' , $filters['status']);
        // }

    }

    public static function rules($id = 0)
    {
        return ([
            //'name' =>  "required|string|min:3|max:255|unique:categories,name,$id",
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),

                /*  function($attribute , $value , $fails) {
                     if(strtolower($value) == 'laravel'){
                       $fails('This name is forbidden!');
                    }
                 },*/
                 'filter:laravel,php,html',
                // new Filter(['laravel' , 'php' , 'html']),
            ],
            'parent_id' => [
                'nullable', 'int', 'exists:categories,id'
            ],

            'image' => [
                'image', 'max:1048576', 'dimensions:min_width=100,min_height=100',
            ],

            'status' => 'required|in:active,archived',
        ]);
    }
}
