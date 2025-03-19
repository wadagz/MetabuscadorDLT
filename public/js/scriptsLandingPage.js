function borrarTexto() {
    document.getElementById("buscarDestino").value = "";
}

function buscarDestino() {
    var destino = document.getElementById("buscarDestino").value;

    if (destino == "") {
        alert("Eliga un Destino");
    }
    else {
        alert(destino);
    }    
}