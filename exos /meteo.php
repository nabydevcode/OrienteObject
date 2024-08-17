<?php
require_once('OpenWeather.php');

$apiKey = '8aff62a6e134b293494b01a4f739971c';
$meteo = new OpenWeather($apiKey);
$resum = $meteo->getForecast('Melun', 'fr');
require_once('elements/header.php');
?>

<div class="container mb-2">
    <h1> La meteo de pour 5 jour selon la ville</h1>
</div>


<div class="container">
    <ul class="list-group list-group-numbered">
        <?php foreach ($resum as $value): ?>
            <li class="list-group-item">
                il est:
                <?= $value['date']->format('d/m/y a H:i') ?> et il fait
                <?= $value['temperature'] ?> °c et la nature du ciel
                est :
                <?= $value['descriptions'] ?>
            </li>
        <?php endforeach ?>
    </ul>
</div>


<?php require_once('elements/footer.php'); ?>