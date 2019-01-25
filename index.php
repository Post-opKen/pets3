<?php
/**
 * Created by PhpStorm.
 * User: Jsmit and Ean Daus
 * Date: 1/18/2019
 * Time: 10:06 AM
 */


//Turn on error reporting
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('vendor/autoload.php');
require_once('model/validation-functions.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

$f3->set('colors', array('pink', 'green', 'blue'));
//Define a default route
$f3->route('GET /', function() {
    echo"<h1>My Pets</h1>";
    echo"<a href='order'>Order a Pet</a>";
});

//Define a parameterized route
$f3->route('GET /@animal', function($f3, $params) {
    $animal = $params['animal'];
    $noise = '';
    if($animal == 'dog')
    {
        $noise = "Woof";
    }elseif($animal == 'chicken')
    {
        $noise = "Cluck";
    }elseif($animal == 'cow')
    {
        $noise = "Moo";
    }elseif($animal == 'cat')
    {
        $noise = "Meow";
    }elseif($animal == 'pig')
    {
        $noise = "Oink";
    }
    else {
        $f3->error(404);
    }
    echo"<h1>$noise!</h1>";
});

//Define a form1 route
$f3->route('GET|POST /order', function($f3) {
    $_SESSION = array();

    if(isset($_POST['animal']))
    {
        $animal = $_POST['animal'];
        if(validString($animal))
        {
            $_SESSION['animal'] = $animal;
            $f3->reroute('/order2');
        }else{
            $f3->set("errors['animal']", "Please enter an animal");
            echo $f3->errors['animal'];
        }
    }
    $template = new Template();
    echo $template->render('views/form1.html');
});

//Define a form2 route
$f3->route('GET|POST /order2', function($f3) {
    if(isset($_POST['color']))
    {
        $color = $_POST['color'];
        if(validColor($color))
        {
            $_SESSION['color'] = $color;
            $f3->reroute('/results');
        }else{
            $f3->set("errors['color']", "Please choose a valid color");
            echo $f3->errors['color'];
        }
    }
    $template = new Template();
    echo $template->render('views/form2.html');
});

//Define a results route
$f3->route('POST|GET /results', function() {
    $template = new Template();
    echo $template->render('views/results.html');
});


//Run fat free
$f3->run();