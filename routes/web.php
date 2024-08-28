<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Versionning 
/*
    Version     : '1.0.0'
    Date        : '28.08.24'
    Auteur      : 'GRI/MDE'
    Description : 'On crée une route post pour envoyer le fichier depuis la view'
*/
//ChangeLog  28.08.24 | 1.0.0 MDE : Création de la requète post


Route::get('/', function () {
    return view('upload');
});

// Requête post pour envoyer le fichier au controller qui permet de lire le code QR d'un pdf
Route::post('/process-pdf', [PdfController::class, 'processPdf'])->name('pdf.process');
