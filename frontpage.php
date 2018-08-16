<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>The Saper - Game</title>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9" crossorigin="anonymous"></script>
        <script src="js/app.js"></script>
<!--        <audio autoplay><source src="music/themeSong.mp3" type="audio/mpeg" /></audio>-->


    </head>
    <body>

        <div class="container">
            <div class="row">
                <h1 class="centered">The Saper Game</h1>
                <img id="mineJpg" src="img/images.png" >
                <h2>Start your adventure</h2>
            </div>
            <div class="row">
                <div class="buttons">
                    <div class="col-6">
                        <form method="post" action="game.php">
                            <input type="hidden" name="size" value="10"/>
                            <input type="submit" value="10 mines"/>
                        </form>
                    </div>
                    <div class="col-6">
                        <form method="post" action="game.php">
                            <input type="hidden" name="size" value="20"/>
                            <input type="submit" value="20 mines"/>
                        </form>
                    </div>
                    <div class="col-6">
                        <form method="post" action="game.php">
                            <input type="hidden" name="size" value="50"/>
                            <input type="submit" value="50 mines"/>
                        </form>
                    </div>
                </div>
                <div class="highscores">
                    <table>
                        <tr>
                            <th><h3>Top scores!</h3></th>
                        </tr>
                        <?php
                        $counter = 1;

                        while ($row = $statement->fetch())
                        {
                            if ($counter >= 10) {
                                break;
                            } else {
                                echo '<tr><td>'.$counter.' ' .$row['name'] . ' ' . $row['time'] . ' seconds'.'</td></tr>';
                                $counter++;
                            }

                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </body>


</html>