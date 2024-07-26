<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Etudiant",
 *     type="object",
 *     title="Etudiant",
 *     required={"code", "nom", "prenom", "date_de_naissance", "adresse", "classe_id"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="code", type="string", maxLength=12),
 *     @OA\Property(property="nom", type="string", maxLength=100),
 *     @OA\Property(property="prenom", type="string", maxLength=150),
 *     @OA\Property(property="date_de_naissance", type="string", format="date"),
 *     @OA\Property(property="adresse", type="string", maxLength=100),
 *     @OA\Property(property="classe_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", readOnly=true, nullable=true)
 * )
 */
class Etudiant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'nom',
        'prenom',
        'date_de_naissance',
        'adresse',
        'classe_id',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
