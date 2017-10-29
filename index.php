<?php
  // Retourne le rang ordinal d'un nombre p.e. 1ière, 2ième, 3ième.
  function rang ($n) {
    return "{$n}<sup>". ($n == 1 ? 'ière' : 'ième') ."</sup>";
  }

  //COMMENTAIRESSSSS!!!
  // Lit les lignes du fichier biblio.txt, applique `rtrim` sur chaque
  // ligne puis les regroupes par ensembles de 9 lignes.
  $ouvrages = array_chunk(array_map('rtrim', file('./biblio.txt')), 11);
  $typesOuvrage = [
    "L" => "Livre",
    "A" => "Article",
    "P" => "Publication scientifique",
  ];

  $index = 0;
  $tousLesId;
  if(!empty($ouvrages)){
    foreach ($ouvrages as $ouvrage) {
      if(!$ouvrage[9]){
        $ouvrages[$index][9] = $typesOuvrage["$ouvrage[8]"]; 
      }

      $tousLesId[] = $ouvrage[0];
      $index++;
    }
  }else{
    $tousLesId[] = "";
  }

  // tri les ouvrages en ordre croissant d'identifiant.
  usort($ouvrages, function ($a, $b) { return $a[0] <=> $b[0]; });
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Biblio</title>
  <style>
    body { margin: 0 auto; width: 600px; }
    .bibitem { margin-bottom: 1rem; position: relative; min-height: 4rem; }
    .identifiant { text-transform: uppercase; font-size: 70%; }
    .ouvrage { display:inline-block; padding-left: 2rem; padding-right: 4rem; }
    .auteurs { font-variant: small-caps; }
    .titre { font-style: italic; }
    .lien a { font-size: 90%; color:#4162C3; }
    .nouveau a{ text-decoration: none; }
    .nouveau { position: absolute; margin: 0 0 20px 0;  }
    /*.messageVide { font-size: 15px; position: absolute; top: 100px }*/
    /*button { position: absolute; top: 150px  }*/
    img { height: 4rem; right: 0; top: 0; position: absolute; filter: drop-shadow(0px 1px 1px gray); }
    img:hover { filter: drop-shadow(0px 1px 2px gray) brightness(1.05); }
  </style>
</head>
<body>
  <?php 
  if(!empty($ouvrages)){ ?>
    <h1>Index</h1>
    <ol>
      <?php foreach ($ouvrages as $ouvrage): ?>
        <li><a href="#<?= $ouvrage[0] ?>"><?= $ouvrage[1] ?></a></li>
      <?php endforeach; ?>
    </ol>
    <h1>Références</h1>
    <?php 
    foreach ($ouvrages as $ouvrage): ?>
      <div id="<?= $ouvrage[0] ?>" class="bibitem">
        <span class="identifiant">[<?= $ouvrage[0] ?>]</span>
        <span class = "lien">
          <a href="delete.php?id=<?=$ouvrage[0] ?> ">Supprimer</a></span>
        <span class="ouvrage">
          <span class="auteurs"><?= $ouvrage[2] ?></span>
          <!--
          <?php if ($ouvrage[3]): ?>
            -->, <span class="annee"><?= $ouvrage[3] ?></span><!--
          <?php endif; ?>
          -->, <span class="titre"><?= $ouvrage[1] ?></span><!--
          -->. <span class="editeur"><?= $ouvrage[4] ?></span><!--
          <?php if ($ouvrage[5]): ?>
            -->, <span class="edition"><?= rang($ouvrage[5]) ?>&nbsp;édition</span><!--
          <?php endif; ?>
          -->, <span class = "edition"><?= $ouvrage[8] . " : " . $ouvrage[9] . "." ?></span>
          <span class = "lien"><a href="<?= $ouvrage[6] ?>" target="_blank">Source</a></span>
        <?php if ($ouvrage[7]): ?>
          <a href="<?= $ouvrage[6] ?>" target="_blank"><img src="<?= $ouvrage[7] ?>" alt="<?= $ouvrage[1] ?>" /></a>
        <?php endif; ?>
      </div>
    <?php endforeach; 
  }else{
    echo"<span class = \"messageVide\">Votre bibliothèque est vide</span>";
  }
  ?>
  <form action="new.php">
    <input type="hidden" name="tousLesId" id="tousLesId" value=<?php implode("," , $tousLesId) ?>/>
    <button>Ajouter un nouveau livre</button>
  </form>
</body>
</html>
