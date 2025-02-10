<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use App\Http\Requests\user\UserUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Contrat;
use App\Models\Prestation;
use App\Models\AgenceUser;
use App\Models\Agence;
use Auth;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with([
            'affectation' => function ($query) {
                $query->whereNull('date_desaffectation');
            }
        ])
            ->with('role')
            ->orderBy('id', 'desc')->get();
        return response()->json([
            "success" => true,
            "users" => $users,
        ]);
        //return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|integer|exists:roles,id',
            'etat' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'etat' => $request->etat,
        ]);

        return response()->json(['user' => $user], 201);
    }


    public function getStatistiqueDashboard()
    {
        $agence_user = AgenceUser::where('user_id', Auth::user()->id)
            ->whereNull('date_desaffectation')
            ->first();

        if (!$agence_user) {
            return response()->json([
                "success" => false,
                "message" => "Agence non trouvée pour l'utilisateur."
            ], 404);
        }

        $agence = Agence::find($agence_user->agence_id);

        if (!$agence) {
            return response()->json([
                "success" => false,
                "message" => "Agence introuvable."
            ], 404);
        }

        $contrats = Contrat::where('etat', 'validé')
            ->where('agence_id', $agence->id)
            ->get();

        $sinistres = Prestation::all();

        $totalengagement = $contrats->sum('montantpret') + $contrats->sum('capitalprevoyance');

        // Groupement des contrats validés par mois
        $contratsParMois = $contrats->groupBy(function ($contrat) {
            return Carbon::parse($contrat->created_at)->format('Y-m'); // Format "YYYY-MM"
        })->map->count();

        // Groupement des sinistres par mois
        $sinistresParMois = $sinistres->groupBy(function ($sinistre) {
            return Carbon::parse($sinistre->created_at)->format('Y-m'); // Format "YYYY-MM"
        })->map->count();

        // Extraction des labels (mois) distincts
        $moisDisponibles = collect(array_merge(
            $contratsParMois->keys()->toArray(),
            $sinistresParMois->keys()->toArray()
        ))->unique()->sort();

        // Transformation en format lisible pour PrimeNG Charts
        $labels = $moisDisponibles->map(function ($mois) {
            return Carbon::createFromFormat('Y-m', $mois)->translatedFormat('F Y'); // Ex : "Janvier 2024"
        })->values()->all();

        $contratsData = $moisDisponibles->map(fn($mois) => $contratsParMois[$mois] ?? 0)->values()->all();
        $sinistresData = $moisDisponibles->map(fn($mois) => $sinistresParMois[$mois] ?? 0)->values()->all();

        return response()->json([
            "success" => true,
            "totalcontrat" => $contrats->count(),
            "totalprime" => formatPrixBf($contrats->sum('primetotale')),
            "totalengagement" => formatPrixBf($totalengagement),
            "totalsinistre" => $sinistres->count(),
            "contratData" => [
                "labels" => $labels,
                "data" => $contratsData
            ],
            "sinistreData" => [
                "labels" => $labels,
                "data" => $sinistresData
            ]
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'etat' => 'required|boolean',
        ]);

        $user->update($request->all());
        return response()->json([
            'messge' => 'Mise à jour éffectuée'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'Type de prestation supprimé'
        ]);
    }
}
