<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Tag</title>
    <style>
        body {
            font-family: Arial, 'sans-serif';
        }

        .bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic
        }
    </style>
</head>
<body>
    <?php 

    require 'SimpleTag.php';

    $tag = new SimpleTag();
    $elems = [
        'div' => ['class' => 'bold italic'],
        'form' => ['id' => 'student-form', 'method' => 'post', 'action' => 'myweb.com']
    ];

    $tag->elem($elems)
        ->setContent('Hello world!', 'h1')
        ->setContent('This text written in PHP', 'h2')
        ->render();
    ?>
</body>
</html>