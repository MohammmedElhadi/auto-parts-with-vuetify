<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReponseController extends Controller
{
    /**
     * get all the offers on my  demande
     */
    public function getAllOffer($demand_id)
    {
        $data = [];
        $reponses = Demande::find($demand_id)->reponses;
        foreach ($reponses as $reponse){
            array_push($data , ["reponse" => $reponse,
                                        "etat"   => $reponse->etat->nom_fr,
                                        "image"   => $reponse->image? asset('storage/'.$reponse->image->url) : null ,
                                        "phone"   => Auth::check()? Auth::user()->phone : "00"]);

        }
        return response()->json($data);
    }

    /**
     * Get my offer on this demande
     */
    public function getMyOffer($demand_id){

        $reponse =  Demande::find($demand_id)->reponses()->where('user_id' , Auth::check()? Auth::id() : 1)->first();
        if ($reponse) {
            $url = "storage/" . $reponse->image->url;
            return response()->json(["reponse" => $reponse,
                "image" => asset($url)
            ]);
        }
        return response()->json(['message' => 'Not Found!'], 404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $reponses = Demande::find($id)->reponses();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
