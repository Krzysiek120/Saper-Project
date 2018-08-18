<!DOCTYPE html>

<html lang="pl">
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9" crossorigin="anonymous"></script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>The Saper Game</title>
    <meta charset="UTF-8">
</head>
<body>
<div style="width:800px; margin: 0 auto; padding:16px">

    <div id="status"></div>
    <div id="game"></div>
    <div id="basicUsage">0</div>
    <div id="song"></div>

    <script>
        var val = " <?php echo $_POST['size'] ?> ";

        if (val == 10) {
            var xSize = 10, ySize = 10, Mines = val;
        } else if (val == 20) {
            var xSize = 12, ySize = 12, Mines = val;
        } else if (val == 50) {
            var xSize = 15, ySize = 15, Mines = val;
        }

    </script>

</div>

<script src="js/app.js"></script>

<form id="scoresForm" class="hidden" method="post" action="saveScores.php">
    <input style="text-align: center; position:absolute; top:20%; left:30%; width:40%;" name="name" type="text" placeholder="Wprowadź swoje imię" id="userInput" />
    <input id="seconds" name="seconds" type="hidden" value="<script></script>"/>
    <input style="position:absolute; top:40%; left:30%; width:40%;" value="Zapisz swój rekord" type="submit" onclick="othername();" />
</form>

</body></html>