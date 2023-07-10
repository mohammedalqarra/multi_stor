<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public static function createWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try{
        $role = Role::create([
            'name' => $request->post('name'),
        ]);

        foreach($request->post('abilities') as $ability)
        {
            RoleAbility::create([
                'role_id' => $role->id,
                'ability_id' => $ability,
                'type' => 'allow',
            ]);
        }
        DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return $role;
    }

    public function updateWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try{
        $this->update([
            'name' => $request->post('name'),
        ]);

        foreach($request->post('abilities') as $ability)
        {
            RoleAbility::updateOrCreate([
                'role_id' => $this->id,
                'ability_id' => $ability,
            ] , [
                'type' => 'allow',
            ]);
        }
        DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return $this;
    }
}
