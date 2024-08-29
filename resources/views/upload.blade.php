<!-- Versionning -->
<!--
    Page        : 'Page upload'
    Version     : '1.0.0'
    Date        : '28.08.24'
    Auteur      : 'GRI/MDE'
    Description : 'Page où on sélectionne la facture et les infos s'affiche'
-->
<!--
ChangeLog  20.08.24 | 1.0.0 MDE : Création de l'html de la page et du css, ajouts de la route et affichage du résultat
-->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
      /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */
      * {
        margin: 0;
        padding: 0;
        box-sizing: none;
        font-family: Roboto;
      }

      nav {
        background-color: rgba(19, 81, 120);
        width: 100%;
        overflow: auto;
        border-bottom: 1px solid black;
      }

      .logo {
        color: white;
        padding-left: 4%;
        padding-top: 1%;
        padding-bottom: 1%;
      }

      .main-container {
        padding-top: 2%;
        padding-left: 4%;
        padding-right: 4%;
      }

      .facture {
        width: 28%;
        float: right;
        margin-right: 2%;
      }

      .title {
        padding-bottom: 1%;
        border-bottom: 2px solid rgba(19, 81, 120);
      }

      .btns {
        padding-top: 3%;
      }

      .input-container{
        padding-top: 5%
      }
    </style>
    <title>Lecture de Code QR</title> 
  </head>
  <body>
    <header>
      <nav>
        <div class="logo">
          <h1>GRI</h1>
        </div>
      </nav>
    </header>
    <div class="main-container"> 
      <h1>Facture</h1>
      <!-- Form avec l'input et le bouton qui pointe sur la route post -->
      <form action="{{ route('pdf.process') }}" method="POST" enctype="multipart/form-data"> 
        @csrf <input type="file" name="pdfFile" id="fileInput" accept="application/pdf" required>
        <button type="submit">Importer la facture</button>
      </form>
      <p id="result">{{ session('result') }}</p>
      <div class="input-container">
      <label for="iban">Iban</label><br>
      <input id="iban" placeholder="{{ $info }}"><br>
      <label for="iban">Fournisseur</label><br>
      <input id="supplier" placeholder="{{ session('info.supplier') }}"><br>
      <label for="iban">Total TTC</label><br>
      <input id="totalTtc" placeholder="{{ session('info.totalTtc') }}"><br>
      <label for="iban">Iban</label><br>
      <input id="cash" placeholder="{{ session('info.cash') }}">
      </div>
    </div>
  </body>
</html>