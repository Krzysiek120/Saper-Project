<!DOCTYPE html>

<html lang="pl"><head>
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
    <style>
        .fel{position:absolute;height:60px;width:60px}
        .fbl{fill:gray}
        .fbl:hover{stroke:black}
        .fcirc:hover{stroke:blue}
        .fsel{stroke:yellow}
        #gwin{display:table;position:absolute;top:0;left:0;width:428px;height:428px;z-index:30;background:rgba(0,0,0,0.75);text-align:center;font-size:20px;color:#FFFFFF;}
        #gstatus{max-width:420px;min-width:248px;text-align:center;border:4px solid #552200;margin: 0 auto}
        #gboard{position:relative;background:#552200;width:428px;height:428px;margin: 0 auto}
    </style>
    <style>
        #game{margin:0 auto;padding:4px; transition:filter 2s}
        #game > div{border:2px solid green;border-style:outset;float:left;background:#AAA;transition:background 1s;text-align:center}
        #game > div:hover{background:#DDD}
        #game > div.mbomb{background:#c62828}
        #game > div.mbomb:hover{background:#ffcdd2}
        #game > div.midk{background:#00695c}
        #game > div.midk:hover{background:#b2dfdb}
        #game > div.sbomb{background:#000}
        #game > div.sel{background:#E5E5E5;font-weight:700}
        #game > div.sel1{color: #33691e}
        #game > div.sel2{color: #827717}
        #game > div.sel3{color: #f57f17}
        #game > div.sel4{color: #ff6f00}
        #game > div.sel5{color: #e65100}
        #game > div.sel6{color: #bf360c}
        #game > div.sel7{color: #b71c1c}
        #game > div.sel8{color: #d50000}
        #status{margin:0 auto;height:30px;line-height:30px;padding:4px}
        .btn{padding:4px;line-height:36px;border: 1px solid black;border-radius:8px;text-decoration:none}
        .btn:hover{color:black}
    </style>

    <div id="status"></div>
    <div id="game"></div>
    <div id="basicUsage">0</div>

    <script>

        var timer = 0;

        setInterval(function(){ timer++; $('#basicUsage').text(timer) }, 1000);

        var val = " <?php echo $_POST['size'] ?> ";



        if (val == 10) {
            var defX = 10, defY = 10, defM = val;
        } else if (val == 20) {
            var defX = 12, defY = 12, defM = val;
        } else if (val == 50) {
            var defX = 15, defY = 15, defM = val;
        }


        var MAXSIZEX = 640;
        var MAXSIZEY = 400;
        var toDiscover = 0;

        var longpress = false;
        var presstimer = null;
        var longtarget = null;

        var cancel = function(e) {
            if (presstimer !== null) {
                clearTimeout(presstimer);
                presstimer = null;
            }
            this.classList.remove("longpress");
        };

        var click = function(e) {
            if (presstimer !== null) {
                clearTimeout(presstimer);
                presstimer = null;
            }
            this.classList.remove("longpress");
            if (longpress) {
                return false;
            }
            markPos(e.target.id, "click");
        };

        var start = function(e) {
            if (e.type === "click" && e.button !== 0) {
                return;
            }
            if (e.button == 2) {
                markPos(e.target.id, "changemark");
                return;
            }
            longpress = false;
            this.classList.add("longpress");
            if (presstimer === null) {
                presstimer = setTimeout(function() {
                    markPos(e.target.id, "changemark");
                    longpress = true;
                }, 300);
            }

            return false;
        };



        function isBomb(id){
            var obj = document.getElementById(id);
            if(obj != null){
                return  obj.classList.contains("bomb");
            }
            return false;
        }

        function countBalls(obj){
            var pos = obj.id.split("x");
            var bombsaround = 0;
            for(var x = parseInt(pos[0]) - 1; x <= parseInt(pos[0]) + 1; x++){
                for(var y = parseInt(pos[1]) - 1; y <= parseInt(pos[1]) + 1; y++){
                    bombsaround += isBomb(x + "x" + y) ? 1 : 0;
                }
            }
            return bombsaround;
        }

        function markPos (id, type) {
            var obj = document.getElementById(id);
            if(obj == null)
                return;
            switch(type){
                case "changemark":
                    if(obj.classList.contains("mbomb")){
                        obj.classList.remove("mbomb");
                        obj.classList.add("midk");
                    } else if (obj.classList.contains("midk")){
                        obj.classList.remove("midk");
                    } else {
                        obj.classList.add("mbomb");
                    }
                    break;
                case "click":
                    if (!(obj.classList.contains("sel") || obj.classList.contains("sbomb"))){
                        if(obj.classList.contains("bomb")){
                            obj.classList.add("sbomb");
                            showMessage('Koniec gry, <a href="javascript:void" onclick="prepareGame(defX, defY, defM)">rozpocznij od nowa</a>');
                            endGame();
                        } else {
                            obj.classList.add("sel");
                            toDiscover--;
                            var balls = countBalls(obj);
                            obj.classList.add("sel" + balls);
                            if(balls == 0){
                                var pos = obj.id.split("x");
                                for(var x = parseInt(pos[0]) - 1; x <= parseInt(pos[0]) + 1; x++){
                                    for(var y = parseInt(pos[1]) - 1; y <= parseInt(pos[1]) + 1; y++){
                                        markPos(x + "x" + y, type);
                                    }
                                }
                            } else {
                                obj.innerHTML = balls;
                            }
                        }
                    }
                    break;
            }
            if(toDiscover == 0){
                showMessage('Gra zakończona sukcesem ! <a href="javascript:void" onclick="prepareGame(defX, defY, defM)">Zagraj jeszcze raz</a>');
                endGame();
            }
        }

        function prepareGame(elx, ely, mines){
            window.oncontextmenu = function (){return false;}
            defX = elx; defY = ely; defM = mines;
            var obj = document.getElementById("game");
            var sizex = (MAXSIZEX) / elx;
            var sizey = (MAXSIZEY) / ely;
            var size = (sizex < sizey) ? sizex : sizey;
            toDiscover = 0;
            obj.innerHTML = "";
            obj.innerHTML += "<style>#game > div{width:"+size+"px;height:"+size+"px;line-height:"+size+"px;font-size:"+(size-2)+"px}</style>"
            var list = [];
            for(var i = 0; i < mines; i++)
                list.push("1");
            for(var i = mines; i < elx*ely; i++){
                list.push("0");
                toDiscover++;
            }
            for(var i = elx*ely - 1; i > 0; i--){
                var chosen = Math.floor(Math.random() * i);
                var swap = list[chosen];
                list[chosen] = list[i];
                list[i] = swap;
            }

            for(var i = 0; i < ely; i++){
                for(var j = 0; j < elx; j++){
                    var div = document.createElement("div");
                    if(list[i*elx+j] == "1")
                        div.classList.add("bomb");
                    div.id = i + "x" + j;
                    div.addEventListener("mousedown", start);
                    div.addEventListener("touchstart", start);
                    div.addEventListener("click", click);
                    div.addEventListener("mouseout", cancel);
                    div.addEventListener("touchend", cancel);
                    div.addEventListener("touchleave", cancel);
                    div.addEventListener("touchcancel", cancel);
                    div.classList.add();
                    obj.appendChild(div);
                }
            }
            obj.style.filter = "";
            obj.style.width=((size + 2)*elx + 4)+"px";
            obj.style.height=((size + 2)*ely + 4)+"px";
            document.getElementById("status").style.width=((size + 2)*elx)+"px";
            showMessage("Wykrytych min: " + mines);
        }

        function showMessage(msg){
            document.getElementById("status").innerHTML = msg;
        }

        function endGame(){
            document.getElementById("game").style.filter = "blur(2px)";
            document.getElementById("game").innerHTML += '<p style="position:absolute;width:'+document.getElementById("game").style.width+';height:'+document.getElementById("game").style.height+';background:rgba(0,0,0,0.2);margin:0"></p>';
        }



        prepareGame(defX, defY, defM);

    </script>


</div>
</body></html>