<?php


$con = mysqli_connect("localhost", "root", "", "immo_php_mysql");

if (mysqli_connect_errno()) {
    echo "Connexion à MySQL échouée: " . mysqli_connect_error();
}
