<?php

// Versionning
/*
    Version     : '1.0.0'
    Date        : '28.08.24'
    Auteur      : 'GRI/MDE'
    Description : 'On récupère le ficher, le transforme en image et on lit son QR Code pour recevoir les informations.'
*/
// ChangeLog  28.08.24 | 1.0.0 MDE : Création de la fonction processPdf

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Imagick;
use Zxing\QrReader;

class PdfController extends Controller
{
    // Fonction qui traite un fichier PDF, le convertit en image JPG, lit le code QR et retourne les informations extraites
    public function fnProcessPdf(Request $request)
    {
        // Récupère le fichier envoyé depuis l'input
        $file = $request->file("pdfFile");

        if ($file) {
            // Vérifie si un fichier a été téléchargé
            try {
                // Chemin d'accès au fichier PDF
                $filePath = $file->getPathName();

                // Initialise un objet Imagick pour le traitement d'image
                $oImagick = new Imagick();
                $oImagick->setResolution(300, 300); // Définit la résolution de l'image
                $oImagick->readImage($filePath . "[0]"); // Lit la première page du PDF
                $oImagick->setImageFormat("jpg"); // Convertit l'image au format JPG

                // Chemin où l'image JPG sera stockée
                $imagePath = storage_path("app/public/output_image.jpg");
                $oImagick->writeImage($imagePath); // Sauvegarde l'image convertie

                // Crée un objet QrReader pour lire le code QR de l'image
                $oQrcode = new QrReader($imagePath);
                $strText = $oQrcode->text(); // Extrait le texte du code QR 

                // Vérifie si un code QR a été détecté et prépare le résultat
                if ($strText) {
                    $lines = explode("\n", $strText);

                    $lines = array_filter(
                        $lines,
                        fn($lines) => trim($lines) !== ""
                    );

                    $info = [
                        "iban" => $lines[3] ?? null,
                        "supplier" => $lines[5] ?? null,
                        "totalTtc" => $lines[18] ?? null,
                        "cash" => $lines[19] ?? null,
                    ];


                    return view("upload")->with($info);
                } else {
                    $strText = "Aucun code QR détecté.";
                    return redirect("/")->with("result", $strText);
                }
            } catch (\Exception $e) {
                // En cas d'erreur, redirige avec un message d'erreur
                return redirect("/")->with(
                    "result",
                    "Erreur lors du traitement du PDF : " . $e->getMessage()
                );
            }
        } else {
            // Si aucun fichier n'est sélectionné, redirige avec un message d'erreur
            return redirect("/")->with("result", "Aucun fichier sélectionné");
        }
    }
}
