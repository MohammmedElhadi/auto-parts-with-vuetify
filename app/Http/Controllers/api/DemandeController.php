<?php

namespace App\Http\Controllers\api;

use App\Events\NewDemandeAdded;
use App\Events\NewReponseAdded;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Image;
use App\Models\Reponse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [];
        foreach (Demande::orderBy('created_at', "desc")->get() as $demande) {
            // dd($demande->marques->first());
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'category' => $demande->categories ? $demande->categories->first() : '',
                'subcategory' => $demande->subcategories ? $demande->subcategories->first() : '',
                'subcategory2' => $demande->subcategory2s ? $demande->subcategory2s->first() : '',
                'marque' => $demande->marques ? $demande->marques->first() : '',
                'modele' => $demande->modeles ? $demande->modeles->first() : '',
                'offers' => $demande->reponses()->pluck('id')
            ]);
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            //dd($request->demand);
            $demande = Demande::create([
                'user_id' => 1,
                // 'user_id'=> Auth::id(),
                'wilaya_id' => $request->wilaya,
                // 'wilaya_id'=> Auth::user()->wilaya->id,
                'etat_id' => $request->etat,
                'note' => $request->note
            ]);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $url = $file->store('demandes');
                $image = Image::create([
                    'url' => $url,
                    'imageable_id' => $demande->id,
                    'imageable_type' => 'App\Models\Demande'
                ]);
            }


            $demande->categories()->attach($request['category']);
            $demande->subcategories()->attach($request['subcategory']);
            $demande->subcategory2s()->attach($request['subsubcategory']);
            $demande->marques()->attach(($request['marques']));
            $demande->modeles()->attach(($request['modeles']));
            $demande->types()->attach($request['type']);

            $demande->notify_interresters();
            event(new NewDemandeAdded($demande));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return response()->json($demande->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $demande = Demande::find($id);
        $data = [];
        array_push($data, [
            'demande' => $demande,
            'type' => $demande->types ? $demande->types[0] : '',
            'category' => $demande->categories ? $demande->categories->first() : '',
            'subcategory' => $demande->subcategories ? $demande->subcategories->first() : '',
            'subcategory2' => $demande->subcategory2s ? $demande->subcategory2s->first() : '',
            'marque' => $demande->marques ? $demande->marques->first() : '',
            'modele' => $demande->modeles ? $demande->modeles->first() : '',
        ]);
        // return response()->json(5);
        // return response()->json(Demande::all());
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * show only my demandes
     */
    public function myDemandes()
    {
        // $demandes =  Auth::user()->demandes;
        $demandes = User::find(1)->demandes;
        $data = [];
        foreach ($demandes as $demande) {
            // dd($demande->marques->first());
            array_push($data, [
                'demande' => $demande,
                'type' => $demande->types ? $demande->types[0] : '',
                'category' => $demande->categories ? $demande->categories->first() : '',
                'subcategory' => $demande->subcategories ? $demande->subcategories->first() : '',
                'subcategory2' => $demande->subcategory2s ? $demande->subcategory2s->first() : '',
                'marque' => $demande->marques ? $demande->marques->first() : '',
                'modele' => $demande->modeles ? $demande->modeles->first() : '',
            ]);
        }
        return $data;

    }

    public function SubmitOffer(Request $request)
    {
        DB::beginTransaction();
        try {
            $offer = Reponse::create([
                'user_id' => Auth::check() ? Auth::id() : 1,
                'demande_id' => $request->demande_id,
                'wilaya_id' => $request->wilaya_id,
                'etat_id' => $request->etat_id,
                'prix_offert' => $request->prix_offert,
                'note' => $request->note,
            ]);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $url = $file->store('reponses');
                $image = Image::create([
                    'url' => $url,
                    'imageable_id' => $offer->id,
                    'imageable_type' => 'App\Models\Reponse'
                ]);
            }
            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return response()->json('error');
        }
        $offer->notify_demander();
        event(new NewReponseAdded($offer));
        return response()->json($offer);
    }
}
