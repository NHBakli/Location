let container_look = document.querySelector(".container_p");

let container_input = document.querySelector(".main2");

let button_modified = document.querySelector(".modified");

let button_cancel = document.querySelector(".cancel");

let button_valid = document.querySelector(".valid");

button_modified.addEventListener("click", function(){
    container_input.style.display = "flex";
    container_look.style.display = "none";
    
})

button_cancel.addEventListener("click", function(){
    container_input.style.display = "none";
    container_look.style.display = "flex";
    
})

button_valid.addEventListener("click", function(){
    container_input.style.display = "none";
    container_look.style.display = "flex";
    
})