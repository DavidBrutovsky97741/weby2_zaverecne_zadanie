window.onload = function() {
  var uniqueTasks;
  var taskIds = [];
  var taskText = [];
  var taskSolution = [];
  var url = new URL(window.location.href);

  // Get the value of the 'taks' parameter
  var params = new URLSearchParams(url.search);
  var taskNumber = params.get('task');

  var tbody = document.getElementById('Tbody');

  $.ajax({
    url: "../../api/tasks/index.php",
    method: "POST",
    data: {
      taskSetId: taskNumber,
    },
    success: function(response) {
      response = JSON.parse(response);

      console.log(response);

      uniqueTasks = response.length;
      for (let i = 0; i < uniqueTasks; i++) {
        taskIds.push(response[i].id);
        taskText.push(response[i].task_text);
        taskSolution.push(response[i].answer);
      }
      console.log("Number of tasks: " + uniqueTasks);

      let count = uniqueTasks; // Use uniqueTasks variable for the count

      for (let i = 0; i < count; i++) {
        var tr = document.createElement('tr');
        tbody.appendChild(tr);

        var td1 = document.createElement('td'); //idecko
        td1.textContent = taskIds[i];
        tr.appendChild(td1);

        var td2 = document.createElement('td'); //set task name
        td2.textContent = 'Maximálny počet bodov';
        tr.appendChild(td2);

        var td3 = document.createElement('td'); // stav
        var state = document.createElement('i');
        state.id = 'state' + taskIds[i];
        state.className = "material-icons";
        state.textContent = "cancel";
        td3.appendChild(state);
        tr.appendChild(td3);

        var td4 = document.createElement('td'); // pisat
        var button = document.createElement('button');
        button.id = taskIds[i];
        button.textContent = 'Písať úlohu';

        button.addEventListener('click', function() {
          writeTask(this.id, response);
        });

        td4.appendChild(button);
        tr.appendChild(td4);
      }
    }
  });
};

function writeTask(id, response) {
  document.getElementById(id).disabled = true;

  document.getElementById('state' + id).innerHTML='check_box';
  var task = response.find(function(task) {
    return task.id === id;
  });

  if (task) {
    console.log("Task ID: " + task.id);
    console.log("Task Name: " + task.task_text);
    console.log("Task Description: " + task.answer);
    // Do something with the task data
  }
}

function englishStudentTranslateTest(){
  document.getElementById('logout').innerHTML = "Log out";
  document.getElementById('navName').innerHTML = " &nbsp; Final task webte2";
  document.getElementById('taskName').innerHTML = "Task";
  document.getElementById('stateName').innerHTML = " State";
  document.getElementById('functionName').innerHTML = " Functions";
  document.getElementById('buttonGenerate').innerHTML = " Submit tasks";

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
  document.getElementById('buttonGenerate').innerHTML = " Odoslať odpovede";

  let i = 0;
  while (true) {

      if (document.getElementById(i) == null) {
          break    
       }

       document.getElementById(i).innerHTML = 'Písať úlohu';
      i++;
    }
}

function submitTaks(){
  //TODO
}