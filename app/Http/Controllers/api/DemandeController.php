<?php

namespace App\Http\Controllers\api;

use App\Events\NewDemandeAdded;
use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Models\Reponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            foreach (Demande::orderBy('created_at' , "desc")->get() as $demande)
            {
                // dd($demande->marques->first());
                array_push($data , [
                    'demande' => $demande,
                    'type'    => $demande->types ? $demande->types[0] : '',
                    'category'    => $demande->categories ? $demande->categories->first(): '',
                    'subcategory'    =>$demande->subcategories?  $demande->subcategories->first() : '',
                    'subcategory2'    =>$demande->subcategory2s ? $demande->subcategory2s->first() : '',
                    'marque'    =>$demande->marques ?   $demande->marques->first() : '',
                    'modele'    =>$demande->modeles ? $demande->modeles->first() : '',
                ]);
            }

        // return response()->json(5);
        // return response()->json(Demande::all());
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try{
            //dd($request->demand);
            $demande = Demande::create([
                'user_id'=> 1,
                // 'user_id'=> Auth::id(),
                'wilaya_id'=> $request->demand["wilaya"],
                // 'wilaya_id'=> Auth::user()->wilaya->id,
                'etat_id'=> $request->demand["etat"],
                'note'=> $request->demand['note']
            ]);
            // if($request->hasFile('images')){
            //     //create pieces jointe
            //     foreach($request->images  as $file)
            //     {
            //         $url = $file->store('images');
            //         $im = new Image;
            //         $im->url = $url;
            //         $demande->images()->save($im);
            //     }
            // }

            $demande->categories()->attach($request->demand['category']);
            $demande->subcategories()->attach($request->demand['subcategory']);
            $demande->subcategory2s()->attach($request->demand['subsubcategory']);
            $demande->marques()->attach($request->demand['marque']);
            $demande->modeles()->attach($request->demand['modele']);
            $demande->types()->attach($request->demand['type']);

            $demande->notify_interresters();
            event(new NewDemandeAdded($demande));
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return response()->json($demande->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd(Demande::find($id));
        $demande = Demande::find($id);
        return response()->json([
            'data' => $demande,
            'type'    => $demande->types[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function SubmitOffer(Request $request)
    {
        $offer  = Reponse::create($request->offer);
        return response()->json($offer);
    }
}
