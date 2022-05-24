$(document).ready(function () {

    $("#signup-form").submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "http://localhost/imove/view/modules/signup.php",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                
                if (response.status === "Algunos campos estan vacios") {
                    emptyFieldsOr("Ningún campo debe quedar vacío.");
                } 
                else if (response.status === "Los campos estan llenos") {
                    goodNews("Muy bien!", "Campos llenos");
                }
                else if (response.status === "Existe en nuestra base de datos") {
                    emptyFieldsOr("Usted se encuentra registrado.");
                }
                else if (response.status === "No existe en nuestra base de datos") {
                    goodNews("Ok!", "Dentro de poco será registrado.");
                }
                else if (response.status === "Registro exitoso") {
                    emptyFieldsOr("Ya estás en la base de datos.");
                }
            },
            error: function (e) {
                emptyFieldsOr("Se ha presentado un error:", e);
            }
        });
    });


    $("#login-form").submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "http://localhost/imove/view/modules/login.php",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                // console.log(response.status);
                if (response.status === "Algunos campos estan vacios") {
                    emptyFieldsOr("Ningún campo debe quedar vacío.");
                } 
                else if (response.status === "Los campos estan llenos") {
                    goodNews("Muy bien!", "Los campos están llenos.");
                }
                else if (response.status === "No esta registrado") {
                    emptyFieldsOr("Usuario no encontrado, revise sus credenciales.");
                }
                else if (response.status === "Usuario encontrado") {
                    // goodNews("Encontrado!", "Este usuario está registrado");
                    window.location.href = "http://localhost/imove/";
                }
                else if (response.status === "Usuario activo") {
                    goodNews("Excelente!", "Esta cuenta está activa.");
                }
                else if (response.status === "Usuario inactivo") {
                    emptyFieldsOr("Esta cuenta está suspendida.");
                }
                else if (response.status === "Usuario administrador") {
                    // goodNews("¡Muy bien!", "Eres un superusuario");
                    window.location.href = "http://localhost/imove/view/modules/administrator.php";
                }
                else if (response.status === "Usuario normal") {
                    // goodNews("Eres normal", "Usuario con credenciales normales.");
                    window.location.href = "http://localhost/imove/view/modules/user.php";
                }
            },
            error: function (e) {
                emptyFieldsOr("Se ha presentado un error:", e);
            }
        });
    });




    /*

    MENSAJES EMERGENTES

    */
    function emptyFieldsOr(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message
        })
    }

    function goodNews(title, msg) {
        Swal.fire({
            icon: 'success',
            title: title,
            text: msg
        });
    }
});

