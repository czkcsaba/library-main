window.onload = () => {
    if (window.location.href == 'http://localhost:8080/'){
        let allStars = document.getElementsByClassName("stars");
        let starsValues = document.getElementsByClassName("starsValue");

        let listOptions = document.getElementById('listOptions');
        let table = document.getElementById('table');
        let attribute = document.getElementById('attribute');
        let searchByAttribute = document.getElementById('searchByAttribute');
        let searchByTable = document.getElementById('searchByTable');
        let listAttributes = {'Címek': {'table': 'books', 'attribute': 'title'},
                              'Írók': {'table': 'writers', 'attribute': 'name'},
                              'Kiadók': {'table': 'publishers', 'attribute': 'name'},
                              'Kategóriák': {'table': 'categories', 'attribute': 'name'}}

        listOptions.onchange = () => {
            let selectedOption = listOptions.options[listOptions.selectedIndex].text;
            listOptions.style.color = "black";

            table.value = listAttributes[selectedOption]['table'];
            attribute.value = listAttributes[selectedOption]['attribute'];
            searchByTable.value = listAttributes[selectedOption]['table'];
            searchByAttribute.value = listAttributes[selectedOption]['attribute'];
        };

        // összes könyv stars eleme
        for (let i = 0; i < allStars.length; i++){
            // az összes csillaga a jelenlegi könyvnek
            let children = allStars[i].children[0].children;
            console.log(starsValues[i].value);
            for (let j = 0; j < 5; j++){
                if (j < starsValues[i].value){
                    children[j].classList.add("fa-solid");
                    children[j].classList.remove("fa-regular");
                }

                // megnyomott csillag
                children[j].addEventListener('click', () => {
                    starsValues[i].value = j + 1;
                    for (let k = 0; k < 5; k++){
                        if (k <= j){
                            children[k].classList.add("fa-solid");
                            children[k].classList.remove("fa-regular");
                        }
                        else{
                            children[k].classList.add("fa-regular");
                            children[k].classList.remove("fa-solid");
                        }
                    }
                });
            }
        }
    }
};