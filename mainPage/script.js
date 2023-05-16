function generateSets() {
    //ziskat pocet setov a ich meno / id
    //praca nad db

    document.getElementById('sets').innerHTML = '';

    let count = 20;    

    for (let i=0;i<count;i++){        

        let randomSetName = (Math.random() + 1).toString(36).substring(5);

        const click = document.createElement('p'); 
        const div = document.createElement('div');
        const img = document.createElement('img');
        const p = document.createElement('p');

        click.setAttribute('class','aLink');
        click.setAttribute('onclick','openModal();');   // pripisat na id

        div.setAttribute('class','folderDiscription');
    

        img.setAttribute('class','imgSets');
        img.setAttribute('src','/weby2_zaverecne_zadanie/images/folder.png');

        p.setAttribute('class','setDiscription');
        p.textContent = 'set_"'+randomSetName+'"';


        $('#sets').append(click);

        click.appendChild(div);
        click.appendChild(img);
        click.appendChild(p); 

    }

}

function openModal(){ // zistak to id a podla toho dat filter na konkretnu sadu
    document.getElementById('modalSet').style.display = 'block';
}


function closeModal(){
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
        if (!['jpg', 'jpeg', 'png', 'gif'].includes(imageExtension)) {
            onlyImages = false;
            break;
        }
    }

    // Loop through the selected LaTeX files and check their extensions
    for (var j = 0; j < latexFiles.length; j++) {
        var latexFile = latexFiles[j];
        var latexExtension = latexFile.name.split('.').pop().toLowerCase();

        // Check if the file extension is not 'tex'
        if (latexExtension !== 'tex') {
            onlyLaTeX = false;
            break;
        }
    }

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

document.getElementById('folderUploadForm').addEventListener('submit', handleFormSubmit);

function newSetUpload(){

    //odosielam zip
    //dosavam odozvu, 200 etc.
}

function studentsOverview(){
    //praca nad db
    // missing frontend
}

function setsToGenerate(){
    // praca nad db
    // missing frontend
}

function pointsForSet(){
    // praca nad db
    // missing frontend    
}
