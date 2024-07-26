<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Classe",
 *     type="object",
 *     title="Classe",
 *     required={"nom"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="nom", type="string", maxLength=100),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", readOnly=true, nullable=true)
 * )
 */
class Classe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nom'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }
}
