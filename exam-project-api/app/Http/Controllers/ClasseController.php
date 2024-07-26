<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Gestion des Classes",
 *     version="1.0.0",
 *     description="Documentation de l'API pour la gestion des classes"
 * )
 */
class ClasseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/classes",
     *     operationId="getClasses",
     *     tags={"Classes"},
     *     summary="Obtenir la liste des classes",
     *     description="Retourne une liste de toutes les classes",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des classes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Classe"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors de la récupération des classes"
     *     )
     * )
     */
    public function index()
    {
        try {
            $classes = Classe::all();
            return response()->json($classes, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des classes',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
