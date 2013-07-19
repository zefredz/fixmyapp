<?php

require_once __DIR__ . '/app/init.php';


echo $twig->render( 'main.html', array( 'title' => 'Greeting', 'body' => 'Hello There !' ) );
