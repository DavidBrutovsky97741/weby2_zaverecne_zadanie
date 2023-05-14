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
