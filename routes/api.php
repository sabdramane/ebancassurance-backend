<?php

use App\Http\Controllers\AgenceController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BeneficiaireController;
use App\Http\Controllers\CaracrteristiquesController;
use App\Http\Controllers\CategorieProduitController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\PreContratController;
use App\Http\Controllers\ContratQuestionnaireController;
use App\Http\Controllers\PreContratQuestionnaireController;
use App\Http\Controllers\DocumentPrestationController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\GarantieController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProduitGarantieController;
use App\Http\Controllers\RapprochementController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TrancheAgeController;
use App\Http\Controllers\TypeContratController;
use App\Http\Controllers\TypePrestationController;
use App\Http\Controllers\VilleController;
use App\Http\Resources\TrancheCapitalResource;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

//Route::middleware('auth:sanctum')->post('users', [AuthController::class, 'user']);

Route::apiResource('users', UserController::class);

Route::apiResource('agences', AgenceController::class);

Route::apiResource('banques', BanqueController::class);

Route::apiResource('beneficiaires', BeneficiaireController::class);

Route::apiResource('caracteristiques', CaracrteristiquesController::class);

Route::apiResource('categorieproduits', CategorieProduitController::class);

Route::apiResource('clients', ClientController::class);

Route::apiResource('contrats', ContratController::class);

Route::apiResource('contratquestionnaires', ContratQuestionnaireController::class);

Route::apiResource('documentprestations', DocumentPrestationController::class);

Route::apiResource('examens', ExamenController::class);

Route::apiResource('garanties', GarantieController::class);

Route::apiResource('medecins', MedecinController::class);

Route::apiResource('prestations', PrestationController::class);

Route::apiResource('produits', ProduitController::class);

Route::apiResource('produit-garanties', ProduitGarantieController::class);

Route::apiResource('rapprochements', RapprochementController::class);

Route::apiResource('simulations', SimulationController::class);

Route::apiResource('tarifs', TarifController::class);

Route::apiResource('trancheages', TrancheAgeController::class);

Route::apiResource('tranchecapitals', TrancheCapitalResource::class);

Route::apiResource('typecontrats', TypeContratController::class);

Route::apiResource('typeprestations', TypePrestationController::class);

Route::apiResource('villes', VilleController::class);

Route::apiResource('roles', RoleController::class);

Route::get('/agences/{libelleparams}/{params_id}', [AgenceController::class, 'findAllByParams']);
Route::get('/produits/{libelleparams}/{params_id}', [ProduitController::class, 'findAllByParams']);
Route::post('/produits-banque', [ProduitController::class, 'insertProduitToBanque']);
Route::get('/banques/{libelleparams}/{params_id}', [BanqueController::class, 'findAllByParams']);
Route::post('/tarifs/produits-banque-tarif', [TarifController::class, 'insertTarifGarantieBanque']);

Route::post('/clients/get-infos', [ClientController::class, 'getInfosClient']);
Route::post('/precontrats/store', [PreContratController::class, 'store']);
Route::post('/precontrats-questionnaire/store', [PreContratQuestionnaireController::class, 'store']);
Route::get('/generer-contrat/{id}', [ContratController::class, 'printContrat']);
