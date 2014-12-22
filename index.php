<?php
/*
index page is a simple redirect
read readme.txt for more info
Questo file non va assolutamente ne rimosso ne modificato.
Contiene le informazioni per il richiamo delle pagine del template in uso
La funzione get_file() svolge il ruolo di richiamo delle pagine a seconda dei parametri richiesti.

Se si vuole modificare il layout delle pagine, basterà accedere alla cartella /template/
e modificare l'html e il css contenuto all'interno dei file.
Il file /template/nome_tema/index.php risulterà essere la index del template in uso.

Per ulteriori informazioni:
scrivere all'autore: stefanopascazi@gmail.it

enjoy!
*/

require 'function/required.function.php';
required();
get_file();