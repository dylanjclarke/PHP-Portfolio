<?php
require_once './vendor/autoload.php';
date_default_timezone_set('America/Louisville');
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);



echo $twig->render("palindrome.html", array());

