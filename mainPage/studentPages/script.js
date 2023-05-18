window.onload = function () {

    var tbody = document.getElementById('Tbody');

    let count = 5;

    for(let i=0;i<count;i++){       

        var tr = document.createElement('tr');
        tbody.appendChild(tr);
        
        var td1 = document.createElement('td'); //idecko
        td1.textContent = i+1;
        tr.appendChild(td1);
        
        var td2 = document.createElement('td');  //set task name
        td2.textContent = 'Maximálny počet bodov';
        tr.appendChild(td2);
        
        var td3 = document.createElement('td'); // stav
        var state = document.createElement('i');
        state.id = 'state' + i;

        state.className = "material-icons";
        state.textContent = "cancel";
        
        td3.appendChild(state);
        tr.appendChild(td3);
        
        var td4 = document.createElement('td'); // pisat
        var button = document.createElement('button');
        button.id = i;
        button.textContent = 'Písať úlohu';
        
        button.addEventListener('click', (function(buttonId) {
            return function() {
              writeTask(buttonId);
            };
          })(button.id));

        td4.appendChild(button);
        tr.appendChild(td4);
        
    }

    /*
    $.ajax({

        url: "/Zadanie4/ip-api/index.php",

        method: "POST",

        data: {
            worker: "get_ip",
        },

        success: function (response) {
            //console.log(response)
            var data = JSON.parse(response);
            //console.log(data)

        }
    })*/

  }

  function writeTask(id){


    document.getElementById(id).disabled = true;

    document.getElementById('state' + id).innerHTML='check_box';
  }

  function englishStudentTranslateTest(){
    document.getElementById('logout').innerHTML = "Log out";
    document.getElementById('navName').innerHTML = " &nbsp; Final task webte2";
    document.getElementById('taskName').innerHTML = "Task";
    document.getElementById('stateName').innerHTML = " State";
    document.getElementById('functionName').innerHTML = " Functions";

    let i = 0;
    while (true) {

        if (document.getElementById(i) == null) {
            break    
         }

         document.getElementById(i).innerHTML = 'Write task';
        i++;
      }

}

function slovakStudentTranslateTest(){
    document.getElementById('logout').innerHTML = "Ohlásiť sa";
    document.getElementById('navName').innerHTML = " &nbsp; Záverečné zadanie webte2";
    document.getElementById('taskName').innerHTML = "Úloha";
    document.getElementById('stateName').innerHTML = " Stav";
    document.getElementById('functionName').innerHTML = " Funkcie";

    let i = 0;
    while (true) {

        if (document.getElementById(i) == null) {
            break    
         }

         document.getElementById(i).innerHTML = 'Písať úlohu';
        i++;
      }
}