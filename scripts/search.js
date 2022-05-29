
function onJsonAdd(json){
    if(json.ok===true)
        console.log("L'inserimento del film nei preferiti nel DB è andato a buon fine");
    else
        console.log("L'inserimento del film neii preferiti nel DB non è andato a buon fine");
}

function addFavorites(event){
    const title=document.getElementById("film_title").textContent;
    const rating=document.getElementById("rating").textContent;
    const formData=new FormData();

    formData.append("title",title);
    formData.append("rating",rating);

    fetch("add_remove_favorites.php", {method: 'post', body: formData}).then(onResponse).then(onJsonAdd);
    
}



function onJson(json){

    console.log(json);
    console.log(json[0].title);
    const button=document.createElement("button");
    button.textContent="Aggiungi ai Preferiti";
    const div_button=document.getElementById("button");
    div_button.appendChild(button);
    button.addEventListener("click",addFavorites);
    const title=document.getElementById("film_title");
    const img=document.getElementById("image");
    const rating=document.getElementById("rating");
    title.textContent=json[0].title;
    img.src=json[0].image;
    rating.textContent="imDb rating: "+json[0].rating;
}

function onResponse(response){
    if (!response.ok) {
        console.log("Response error");
        return null};
    return response.json();
}


function search(event){
    event.preventDefault();
    const title_input=document.getElementById("title_search");
    const title_value=encodeURIComponent(title_input.value);

    console.log(title_value);
    fetch("fetch_film.php?title="+title_value).then(onResponse).then(onJson);
    
}




document.querySelector('form').addEventListener('submit',search);