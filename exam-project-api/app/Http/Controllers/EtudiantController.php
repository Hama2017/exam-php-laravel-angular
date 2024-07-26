<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Info(
 *     title="API de Gestion des Étudiants",
 *     version="1.0.0",
 *     description="Documentation de l'API pour la gestion des étudiants et des classes"
 * )
 */
class EtudiantController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/etudiants",
     *     operationId="storeEtudiant",
     *     tags={"Etudiants"},
     *     summary="Créer un nouvel étudiant",
     *     description="Enregistre un nouvel étudiant dans la base de données",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom","prenom","date_de_naissance","adresse","classe_id"},
     *             @OA\Property(property="nom", type="string", maxLength=100),
     *             @OA\Property(property="prenom", type="string", maxLength=150),
     *             @OA\Property(property="date_de_naissance", type="string", format="date"),
     *             @OA\Property(property="adresse", type="string", maxLength=100),
     *             @OA\Property(property="classe_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Étudiant créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Etudiant")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors de la création de l'étudiant"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'required|max:150',
            'date_de_naissance' => 'required|date',
            'adresse' => 'required|max:100',
            'classe_id' => 'required|exists:classes,id',
        ]);

        try {
            $code = $this->generateStudentCode(
                $validated['classe_id'],
                $validated['prenom'],
                $validated['nom'],
                $validated['date_de_naissance']
            );

            $etudiant = Etudiant::create(array_merge($validated, ['code' => $code]));

            return response()->json($etudiant, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la création de l\'étudiant',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/etudiants",
     *     operationId="getEtudiants",
     *     tags={"Etudiants"},
     *     summary="Liste des étudiants",
     *     description="Affiche une liste des étudiants",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des étudiants",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Etudiant"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors de la récupération des étudiants"
     *     )
     * )
     */
    public function index()
    {
        try {
            $etudiants = Etudiant::all();
            return response()->json($etudiants);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des étudiants',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/etudiants/classe/{classe_id}",
     *     operationId="getEtudiantsByClasse",
     *     tags={"Etudiants"},
     *     summary="Liste des étudiants par classe",
     *     description="Affiche les étudiants d'une classe spécifique",
     *     @OA\Parameter(
     *         name="classe_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des étudiants",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Etudiant"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Classe non trouvée"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur lors de la récupération des étudiants"
     *     )
     * )
     */
    public function showByClasse($classe_id)
    {
        try {
            $etudiants = Etudiant::where('classe_id', $classe_id)->get();
            return response()->json($etudiants);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Classe non trouvée',
                'message' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des étudiants',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Génère un code étudiant unique basé sur les informations fournies.
     *
     * @param  int     $classe_id
     * @param  string  $prenom
     * @param  string  $nom
     * @param  string  $date_de_naissance
     * @return string
     */
    private function generateStudentCode($classe_id, $prenom, $nom, $date_de_naissance)
    {
        $firstLetterPrenom = strtoupper(substr($prenom, 0, 1));
        $firstLetterNom = strtoupper(substr($nom, 0, 1));
        $anneeNaissance = date('Y', strtotime($date_de_naissance));
        $randomNumber = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);

        // Limitez l'ID de classe à 5 caractères pour assurer une longueur totale <= 20
        $classe_id_short = substr($classe_id, 0, 5);

        return $classe_id_short . $firstLetterPrenom . $firstLetterNom . $anneeNaissance . $randomNumber;
    }
}
