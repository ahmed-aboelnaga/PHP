<?php
 // Inclusion de la bibliothèque de fonctions :
 require('lib/fonctionsLivre.php');
 
 // Lecture  du fichier et mémorisation dans des variables PHP :
 $file = fopen('data/livres.txt','r');
 $booksHTML = libraryToHTML($file);
 fclose($file);
 // inclusion de la page template :
 require('views/pageLivres.php');
?>