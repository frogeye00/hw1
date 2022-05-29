function onJson(json){

    const table=document.querySelector("table");
    for(let i in json){

        const tr=document.createElement("tr");
        const td_title=document.createElement("td");
        const td_rating=document.createElement("td");
        const td_remove=document.createElement("td");

        td_title.classList.add("title");
        td_rating.classList.add("rating");
        td_remove.classList.add("remove");


        const button=document.createElement("button");

        td_title.textContent=json[i].title;
        td_rating.textContent=json[i].rating;

        button.textContent="Rimuovi dai preferiti";
        button.addEventListener("click",removeFavorites);

        td_remove.appendChild(button);

        tr.appendChild(td_title);
        tr.appendChild(td_rating);
        tr.appendChild(td_remove);
        
        table.appendChild(tr)

    }

}

function onJsonRemove(json){
    if(json.ok===true)
        console.log("La cancellazione del film dai preferiti nel DB è andato a buon fine");
    else
        console.log("La cancellazione del film dai preferiti nel DB non è andato a buon fine");
}

function onResponse(response){
    if (!response.ok) {
        console.log("Response error");
        return null};
    return response.json();
}


function fetchFavorites(){
    fetch("fetch_favorites.php").then(onResponse).then(onJson);
}

function removeFavorites(event){
    const tr=event.currentTarget.parentNode.parentNode;
    const table=document.querySelector("table");
    const title=tr.querySelector(".title").textContent;

    table.removeChild(tr);
    const title_value=encodeURIComponent(title);
    fetch("add_remove_favorites.php?title="+title_value).then(onResponse).then(onJsonRemove);
}



fetchFavorites();