<?php
// Je hebt een database nodig om dit bestand te gebruiken....
include "database.php";
if (!isset($db_conn)) { //deze if-statement checked of er een database-object aanwezig is. Kun je laten staan.
  return;  
}



$database_gegevens = null;
$poolIsChecked = false;
$bathIsChecked = false;

$sql = "SELECT * FROM homes WHERE 1"; //Selecteer alle huisjes uit de database
if (isset($_GET['filter_submit'])) {

    if ($_GET['faciliteiten'] == "ligbad") { // Als ligbad is geselecteerd filter dan de zoekresultaten
        $bathIsChecked = true;

        $sql = "SELECT * FROM homes WHERE bath_present = 1"; // query die zoekt of er een BAD aanwezig is.
    }

    if ($_GET['faciliteiten'] == "zwembad") {
        $poolIsChecked = true;

        $sql = "SELECT * FROM homes WHERE pool_present = 1"; // query die zoekt of er een ZWEMBAD aanwezig is.
    }
}
    if ($_GET['faciliteiten'] == "bbq") {
        $bbqIsChecked = true;

        $sql = "SELECT * FROM homes WHERE bbq_present = 1 "; // query die zoekt of er een BBQ aanwezig is.
    }

     if ($_GET['faciliteiten'] == "dishwasher") {
        $dishwasherIsChecked = true;

        $sql = "SELECT * FROM homes WHERE dishwasher_present = 1 "; // query die zoekt of er een BBQ aanwezig is.
    }
    
    if ($_GET['faciliteiten'] == "bbq") {
        $bbqIsChecked = true;

        $sql = "SELECT * FROM homes WHERE bbq_present = 1 "; // query die zoekt of er een BBQ aanwezig is.
    }
if (is_object($db_conn->query($sql))) { //deze if-statement controleert of een sql-query correct geschreven is en dus data ophaalt uit de DB
    $database_gegevens = $db_conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); //deze code laten staan
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <link href="css/index.css" rel="stylesheet">
</head>

<body>
    <header>
        <h1>Mike's BNB Palace </h1>
    </header>
    <main>
        <div class="left">
            <div id="mapid"></div>
            <div class="book">
                <h3>Reservering maken</h3>
                <div class="form-control">
                    <label for="aantal_personen">Vakantiehuis</label>
                    <select name="gekozen_huis" id="gekozen_huis">
                        <option value="1">IJmuiden Cottage</option>
                        <option value="2">Assen Bungalow</option>
                        <option value="3">Espelo Entree</option>
                        <option value="4">Weustenrade Woning</option>
                    </select>
                </div>
                <div class="form-control">
                    <label for="aantal_personen">Aantal personen</label>
                    <input type="number" name="aantal_personen" id="aantal_personen">
                </div>
                <div class="form-control">
                    <label for="aantal_dagen">Aantal dagen</label>
                    <input type="number" name="aantal_dagen" id="aantal_dagen">
                </div>
                <div class="form-control">
                    <h5>Beddengoed</h5>
                    <label for="beddengoed_ja">Ja</label>
                    <input type="radio" id="beddengoed_ja" name="beddengoed" value="ja">
                    <label for="beddengoed_nee">Nee</label>
                    <input type="radio" id="beddengoed_nee" name="beddengoed" value="nee">
                </div>
                <button>Reserveer huis</button>
            </div>
            <div class="currentBooking">
                <div class="bookedHome"></div>
                 <?php  $totaal = ($huisje ['price_p_p_p_n'] * 'aantal_dagen' * 'aantal_personen'); ?>
                <div class="totalPriceBlock"><Totale prijs> &euro;<span class="totalPrice"><?php echo $totaal;?></span></div>
            </div>
            </div>
        <div class="right">
            <div class="filter-box">
                <form class="filter-form">
                    <div class="form-control">
                        <a href="index.php">Reset Filters</a>
                    </div>
                    <div class="form-control">
                        <label for="ligbad">Ligbad</label>
                        <input type="radio" id="ligbad" name="faciliteiten" value="ligbad" <?php if ('$bathIsChecked') echo 'checked' ?>>
                    </div>
                    <div class="form-control">
                        <label for="zwembad">Zwembad</label>
                        <input type="radio" id="zwembad" name="faciliteiten" value="zwembad" <?php if ('$poolIsChecked') echo 'checked' ?>>
                    </div>

                    <div class="form-control">
                        <label for="wifi">Wifi</label>
                        <input type="radio" id="wifi" name="faciliteiten" value="wifi" <?php if ('$wifiIsChecked') echo 'checked' ?>>
                    </div>

                    <div class="form-control">
                        <label for="bbq">Open Haard</label>
                        <input type="radio" id="open haard" name="faciliteiten" value="bbq" <?php if ('$bbqIsChecked') echo 'checked' ?>>
                    </div>
                    <div class="form-control">
                        <label for="dishwasher">Vaatwasser</label>
                        <input type="radio" id="dishwasher" name="faciliteiten" value="dishwasher" <?php if ('$dishwasherIsChecked') echo 'checked' ?>>
                    </div>

                    <div class="form-control">
                        <label for="bike">Fietsverhuur</label> 
                        <input type="radio" id="bike" name="faciliteiten" value="bike" <?php if ('$bikeIsChecked') echo 'checked' ?>>
                    </div>
                    <button type="submit" name="filter_submit">Filter</button>
                    
                    <div class = "images"></div>
                    <img src = images/Ijmuiden.jpg width = 85% height = 15%>
                </form>
                <div class="homes-box">
                    <?php if (isset($database_gegevens) && $database_gegevens != null) : ?>
                        <?php foreach ($database_gegevens as $huisje) : ?>
                            <h4>
                                <?php echo $huisje['name'] ?>;
                            </h4>
                            <div>
                            <img class="images" src="images/<?php echo $huisje['image'];?>" style="width: 473.997; height: 315px;">
                            </div>

                            <p>
                                <?php echo $huisje['description'] ?>;
                            </p>
                            <div class="kenmerken">
                                <h6>Kenmerken</h6>
                                <ul>

                                    <?php
                                    if ($huisje['bath_present'] ==  1) {
                                        echo "<li>Ligbad</li>";
                                    }
                                    ?>


                                    <?php
                                    if ($huisje['pool_present'] ==  1) {
                                        echo "<li>Zwembad</li>";
                                    }
                                    ?>

                                    <?php
                                    if ($huisje['wifi_present'] ==  1) {
                                        echo "<li>Wifi</li>";
                                    }
                                    ?>

                                    <?php
                                    if ($huisje['bbq_present'] ==  1) {
                                        echo "<li>BBQ</li>";
                                    }
                                    ?>

                                    <?php
                                    if ($huisje['fireplace_present'] ==  1) {
                                        echo "<li>Open Haard</li>";
                                    }
                                    ?>
                                </ul>

                            </div>
                            
                            <?php endforeach; ?>
           
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </main>
    <footer>
        <div></div>
        <div>copyright Mike's BNB Palace BV.</div>
        <div></div>

    </footer>
    <script src="js/map_init.js"></script>
    <script>
        // De verschillende markers moeten geplaatst worden. Vul de longitudes en latitudes uit de database hierin
        var coordinates = [
            [52.44902,4.61001],
            [52.99864,6.64928],
            [52.30340,6.36800],
            [50.89720,5.90979]

    ];

        var bubbleTexts = [
        "<h2>Ijmuiden Cottage</h2> <img src=images/Ijmuiden.jpg width = 100% height= 110%>",
        "<h2>Assen Bungalow</h2> <img src=images/Assen.jpg width = 100% height= 110%>",
        "<h2>Espelo Entree</h2> <img src=images/Espelo.jpg width = 100% height= 110%>",
        "<h2>Weustenrade Woning</h2> <img src=images/Weustenrade.jpg width = 100% height= 110%>",

        ];
    </script>
    <script src="js/place_markers.js"></script>

</body>
</html>