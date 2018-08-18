$(function() {


    var timer = 0;

    var interval = setInterval(function(){ timer++; $('#basicUsage').text(timer) }, 1000);

    // $.post("saveScores.php",
    //     {
    //         name: "Donald Duck",
    //         city: "Duckburg"
    //     },
    //     function(data, status){
    //         alert("Data: " + data + "\nStatus: " + status);
    //     });

    // $.ajax({
    //     url: 'saveScores.php', //This is the current doc
    //     type: "POST",
    //     dataType:'json', // add json datatype to get json
    //     data: ({score: timer}),
    //     success: function(data){
    //         console.log(data);
    //     }
    // });


    if (val == 10) {
        var xSize = 10, ySize = 10, Mines = val;
    } else if (val == 20) {
        var xSize = 12, ySize = 12, Mines = val;
    } else if (val == 50) {
        var xSize = 15, ySize = 15, Mines = val;
    }

    var maxXWidth = 640;
    var maxYWidth = 400;
    var minesToOpen = 0;

    var longpress = false;
    var clickTime = null;
    var objectSpace = null;

    var cancel = function(e) {
        if (clickTime !== null) {
            clearTimeout(clickTime);
            clickTime = null;
        }
        this.classList.remove("longpress");
    };

    var click = function(e) {
        if (clickTime !== null) {
            clearTimeout(clickTime);
            clickTime = null;
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
        if (clickTime === null) {
            clickTime = setTimeout(function() {
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
                        showMessage('Koniec gry, <a href="javascript:void" onclick="Start(xSize, ySize, Mines)">rozpocznij od nowa</a>');
                        document.getElementById('song').innerHTML = '<audio autoplay><source src="music/loughing.mp3" type="audio/mpeg" /></audio>';
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
            showMessage('Gra zakończona sukcesem ! <a href="javascript:void" onclick="Start(xSize, ySize, Mines)">Zagraj jeszcze raz</a>');
            document.getElementById('song').innerHTML = '<audio autoplay><source src="music/applause.mp3" type="audio/mpeg" /></audio>';
            myStopFunction(interval);

            $('#seconds').val(timer);

            document.querySelector('#scoresForm').classList.remove('hidden');
            endGame();
        }
    }

    function myStopFunction() {
        clearInterval(interval);
    }

    function Start(elx, ely, mines){
        window.oncontextmenu = function (){return false;}
        xSize = elx; ySize = ely; Mines = mines;
        var obj = document.getElementById("game");
        var sizex = (maxXWidth) / elx;
        var sizey = (maxYWidth) / ely;
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
        document.getElementById("game").innerHTML += '<p style="position:absolute;width:'+document.getElementById("game").style.width+';height:'+document.getElementById("game").style.height+';margin:0"></p>';
    }

    Start(xSize, ySize, Mines);

});