function ejecutar (data) {
    var object;
    object = {
        "write": function (dato) {
            document.getElementById("content").innerHTML = dato;
        }

    };
    object.write(data);

}