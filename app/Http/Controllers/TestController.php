<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Afficher le formulaire de test
     */
    public function index()
    {
        return view('test-form');
    }
    
    /**
     * Traiter la soumission du formulaire de test
     */
    public function submit(Request $request)
    {
        // Validation simple
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        
        // Juste pour afficher que le formulaire fonctionne
        return redirect()->route('test.form')->with('success', 'Formulaire soumis avec succès ! Nom: ' . $request->name . ', Email: ' . $request->email);
    }
}
