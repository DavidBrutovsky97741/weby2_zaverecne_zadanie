images = [];
fileName = "";
latexContent = "";
uniqueSets = [];
elementId = "";
$.ajax({
    url: "http://localhost:8000/api/tasks/index.php",
    method: "GET",
    success: function (response) {
        //console.log(response);
        response = JSON.parse(response);
        for (let i = 0; i < response.length; i++) {
            if (uniqueSets.includes(response[i].id)) {
                continue;
            } else {   
                uniqueSets.push(response[i].id);
            }
        }
    }
});



function generateSets() {
    //ziskat pocet setov a ich meno / id


    // console.log(uniqueSets);
    document.getElementById('sets').innerHTML = '';

    let count = uniqueSets.length;
    
    //console.log(uniqueSets[0]);
    
    for (let i = 0; i < count; i++) {

        let randomSetName = (Math.random() + 1).toString(36).substring(5);

        const click = document.createElement('p');
        const div = document.createElement('div');
        const img = document.createElement('img');
        const p = document.createElement('p');

        //console.log(uniqueSets[i]);

        click.setAttribute('class', 'aLink');
        click.setAttribute('id', uniqueSets[i]);
        click.setAttribute('onclick', 'openModal(this.id);');   //TODO: iba id bolo v url
        div.setAttribute('class', 'folderDiscription');


        img.setAttribute('class', 'imgSets');
        img.setAttribute('src', '/images/folder.png');

        p.setAttribute('class', 'setDiscription');
        p.textContent = 'set_"' + randomSetName + '"';


        $('#sets').append(click);

        click.appendChild(div);
        click.appendChild(img);
        click.appendChild(p);

    }

}

function openModal(id) { // zistak to id a podla toho dat filter na konkretnu sadu
    elementId = id;
    //alert(elementId);
    let buttonElement = document.getElementById('testWrite');

    buttonElement.onclick = function() {
        testWritingTask(id);
      };

    document.getElementById('modalSet').style.display = 'block';

}
function testWritingTask(id) { //id task setu
    console.log(id);
    //console.log(elementId);
    window.location.href = "studentPages/testWriting.php?taks="+elementId;

}

function closeModal() {
    document.getElementById('modalSet').style.display = 'none';
    
}




function handleFormSubmit(event) {
    event.preventDefault(); // Prevent form submission

    var imageFolderInput = document.getElementById('imageFolder');
    var latexFolderInput = document.getElementById('latexFolder');

    // Check if the file inputs exist
    if (!imageFolderInput || !latexFolderInput) {
        alert('Unable to find file inputs. Please make sure they exist.');
        return;
    }

    var imageFiles = imageFolderInput.files;
    var latexFiles = latexFolderInput.files;
    var onlyImages = true;
    var onlyLaTeX = true;

    // Loop through the selected image files and check their extensions
    for (var i = 0; i < imageFiles.length; i++) {
        var imageFile = imageFiles[i];

        var imageExtension = imageFile.name.split('.').pop().toLowerCase();



        // Check if the file extension is not an image extension
        if (!['jpg', 'jpeg', 'png'].includes(imageExtension)) {
            onlyImages = false;
            break;
        } else {
            var reader = new FileReader();
            reader.onload = function (event) {
                var imageContent = event.target.result;

                var imageObject = {
                    "fileName": imageFile.name,
                    "image64": imageContent
                }

                images.push(imageObject);
                // console.log(images);
            };
            reader.readAsDataURL(imageFile);
        }
    }

    // Loop through the selected LaTeX files and check their extensions
    for (var j = 0; j < latexFiles.length; j++) {
        var latexFile = latexFiles[j];
        fileName = latexFile.name;
        var latexExtension = latexFile.name.split('.').pop().toLowerCase();
        // Check if the file extension is not 'tex'
        if (latexExtension !== 'tex') {
            onlyLaTeX = false;
            break;
        }
    }
    var reader = new FileReader();
    reader.onload = function (event) {
        // var contents = event.target.result;
        // console.log("File contents:", contents);
        // latexContent = contents;
        latexContent = event.target.result;
        // console.log(latexContent);
        sendData(latexContent, images, fileName);
    };
    reader.readAsText(latexFile);


    // Display the result based on the onlyImages and onlyLaTeX variables
    if (onlyImages && onlyLaTeX) {
        alert('The image folder contains only images, and the LaTeX folder contains only LaTeX files.');
    } else if (onlyImages) {
        alert('The image folder contains only images, but the LaTeX folder contains files other than LaTeX files.');
    } else if (onlyLaTeX) {
        alert('The LaTeX folder contains only LaTeX files, but the image folder contains files other than images.');
    } else {
        alert('The folders contain files other than the specified types.');
    }

    // Clear the selected files
    imageFolderInput.value = '';
    latexFolderInput.value = '';

}

if (document.getElementById('folderUploadForm') !== null) {
    document.getElementById('folderUploadForm').addEventListener('submit', handleFormSubmit);
}


function sendData(latexContent, images, fileName) {
    images = images || [];
    $.ajax({
        url: "../api/newSet/index.php",
        method: "POST",
        data: JSON.stringify({
            "name": fileName,
            "maxPoints": 10,
            "text": latexContent,
            "images": images
        }),
        success: function (response) {
            console.log(response);
        }
    });
}

function newSetUpload() {

    //odosielam zip
    //dosavam odozvu, 200 etc.
}

function studentsOverview() {
    //praca nad db
    // missing frontend
}

function setsToGenerate() {
    // praca nad db
    // missing frontend
}

function pointsForSet() {
    // praca nad db
    // missing frontend    
}

function slovakStudent() {
    document.getElementById('buttonGenerate').innerHTML = "Generuj sady úloh";
    document.getElementById('logout').innerHTML = "Ohlásiť sa";
    document.getElementById('navName').innerHTML = " &nbsp; Záverečné zadanie webte2";


    if (document.getElementById('setsEmptyInfo') !== null) {
        document.getElementById('setsEmptyInfo').innerHTML = " Tu sa zobrazia generované sety úloh";
    }
    document.getElementById('taskStateTranslate').innerHTML = "Stav ";
    document.getElementById('pointsTranslate').innerHTML = " Maximálny počet bodov";
    document.getElementById('countTasksTranslate').innerHTML = " Počet úloh";
    document.getElementById('closeModal').innerHTML = "Zatvoriť";
    document.getElementById('testWrite').innerHTML = "Písať test";
}

function englishStudentTranslate() {
    document.getElementById('buttonGenerate').innerHTML = "Generate sets of tasks";
    document.getElementById('logout').innerHTML = "Log out";
    document.getElementById('navName').innerHTML = " &nbsp; Final task webte2";

    if (document.getElementById('setsEmptyInfo') !== null) {
        document.getElementById('setsEmptyInfo').innerHTML = " Here will be shown generated sets of tasks";
    }
    document.getElementById('taskStateTranslate').innerHTML = " State";
    document.getElementById('pointsTranslate').innerHTML = " Max points";
    document.getElementById('countTasksTranslate').innerHTML = " Number of tasks";
    document.getElementById('closeModal').innerHTML = "Close";
    document.getElementById('testWrite').innerHTML = "Write test";
}

function slovakTeacher() {
    document.getElementById('logout').innerHTML = "Ohlásiť sa";
    document.getElementById('navName').innerHTML = " &nbsp; Záverečné zadanie webte2";
    document.getElementById('newSetName').innerHTML = " Nahrať novú sadu";
    document.getElementById('studentsOverview').innerHTML = " Prehľad študentov";
    document.getElementById('whatToGenerate').innerHTML = " Výber sád na generovanie";
    document.getElementById('changePoints').innerHTML = " Zmeniť body za sadu";
}

function englishTeacherTranslate() {
    document.getElementById('logout').innerHTML = "Log out";
    document.getElementById('navName').innerHTML = " &nbsp; Final task webte2";
    document.getElementById('newSetName').innerHTML = " Upload new set";
    document.getElementById('studentsOverview').innerHTML = " Students overview";
    document.getElementById('whatToGenerate').innerHTML = " Pick sets to generate";
    document.getElementById('changePoints').innerHTML = " Change points of set";
}

function englishStudentTranslateTest() {
    document.getElementById('logout').innerHTML = "Log out";
    document.getElementById('navName').innerHTML = " &nbsp; Final task webte2";
}

function slovakStudentTranslateTest() {
    document.getElementById('logout').innerHTML = "Ohlásiť sa";
    document.getElementById('navName').innerHTML = " &nbsp; Záverečné zadanie webte2";
}
