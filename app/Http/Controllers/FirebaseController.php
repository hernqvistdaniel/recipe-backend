<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase;

use Kreait\Firebase\Factory;

use Kreait\Firebase\ServiceAccount;

use Kreait\Firebase\Database;

class FirebaseController extends Controller
{
    // Gets all recipes
    public function index()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/recipeappbackend-a93cc-1060f9102bb7.json');

        $firebase = (new Factory)
          ->withServiceAccount($serviceAccount)
          ->withDatabaseUri('https://recipeappbackend-a93cc.firebaseio.com')
          ->create();

        $database = $firebase->getDatabase();
        $recipes = $database->getReference('recipes')->getValue();

        return response()->json($recipes);
    }

    // Create
    public function store(Request $request)
    {
        $recipes = json_decode($request->getContent());
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/recipeappbackend-a93cc-1060f9102bb7.json');

        $firebase = (new Factory)
          ->withServiceAccount($serviceAccount)
          ->withDatabaseUri('https://recipeappbackend-a93cc.firebaseio.com')
          ->create();

        $database = $firebase->getDatabase();

        $database->getReference('recipes')->set($recipes);
        
        $updatedRecipes = $database->getReference('recipes')->getValue();

        return response()->json($updatedRecipes);
    }
}
