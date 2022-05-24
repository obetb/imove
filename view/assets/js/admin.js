$(document).ready(function() {
    
    
    let table_users = $('#table_users').DataTable({
        "ajax": {
            "url": "http://localhost/imove/view/modules/administrator.php",
            "method": "POST",
            "data": { option: "viewUsers" },
            "dataSrc": ""
        },
        "columns": [
            { "data": "iduser" },
            { "data": "name" },
            { "data": "email" },
            { "data": "photo" },
            { "data": "role" },
            { "data": "status" },
            { "data": "edit" },
            { "data": "delete" }
        ]
    });
    
    /* 
        CRUD de usuarios por parte de un administrador
    */

    insertUser();
    getParticularUser();
    updateUser();
    deleteUser();

});


function insertUser() {
    $(document).on("click", "#btnRegisterUser", function () {

        let name = $.trim($("#name").val());
        let email = $.trim($("#email").val());
        let password = $.trim($("#password").val());
        let role = $.trim($("#role").val());
        let status = $.trim($("#status").val());

        if (name === "" || email === "" || password === "" || role === "" || status === "") {
            emptyFieldsOr("Ningún campo debe quedar vacío!");
        }
        else {
            let formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);
            formData.append("password", password);
            formData.append("role", role);
            formData.append("status", status);
            formData.append("option", "insertUser");
            
            /* Con esto se veq qué valores tiene el formData.
               Se tiene que comentar $.ajax() para que se pueda visualizar.
            */
            /*
            for (let entrie of formData.entries()) {
                console.log(entrie[0]+ ': ' + entrie[1]); 
            }
            */
            $.ajax({
                url: "administrator.php",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    data = $.parseJSON(data);
                    console.log(data);
                    
                    if (data.status === "Este usuario existe") {
                        emptyFieldsOr("El correo está asociada a otra cuenta, pruebe con otro.");
                    }
                    else if (data.status === "Usuario gregado correctamente") {
                        goodNews("Enhorabuena...", "Has agregado un nuevo usuario.");
                        $("#userModal").modal("hide");
                        $("form").trigger("reset");
                        $('#table_users').DataTable().ajax.reload();
                    }
                    else if (data.status === "No se pudo agregar el usuario") {
                        emptyFieldsOr("Algo malo pasó, no se pudo crear este usuario.");
                    }
                }
            });
        }
    });
}


function getParticularUser() {
    $(document).on("click", "#btnEdit", function () {
        let id = $(this).attr("data-id");
        // console.log("Id:", id);
        $.ajax({
            url: "administrator.php",
            method: "POST",
            data: { id: id, option: "getParticularUser" },
            dataType: "JSON",
            success: function(response) {
                console.table(response);

                $("#updateId").val(id);
                $("#updateName").val(response["user_name"]);
                $("#updateEmail").val(response["user_email"]);
                $("#updateRole").val(parseInt(response["role"]));
                $("#updateStatus").val(parseInt(response["status"]));

                $("#updateUserModal").modal("show");
            }
        });
    });
}

function updateUser() {
    $(document).on("click", "#btnUpdateUser", function () {
        let updateId = $("#updateId").val();
        let updateName = $("#updateName").val();
        let updateEmail = $("#updateEmail").val();
        let updateRole = $("#updateRole").val();
        let updateStatus = $("#updateStatus").val();
        
        if (updateName === "" || updateEmail === "" || updateRole === "" || updateStatus === "") {
            emptyFieldsOr("Revisa que ningún campo esté vacío.");
        }
        else {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizalo!'
            }).then((result) => {
                $("#updateUserModal").modal("hide");
                
                if (result.isConfirmed) {
                    $.ajax({
                        url: "administrator.php",
                        method: "POST",
                        data: { id: updateId, name: updateName, email: updateEmail, role: updateRole, status: updateStatus, option: "updateUser" },
                        success: function(data) {
                            data = $.parseJSON(data);

                            if (data.status === "Usuario actualizado") {
                                // console.log("Estado actualizado ");
                                $('#table_users').DataTable().ajax.reload();
                                
                                goodNews("Bien hecho", "Has actualizado la información sin problemas.");

                            } else if (data.status === "Usuario no actualizado") {
                                // console.log("No actualizado");
                                emptyFieldsOr("No se pudo realizar la actualización.");
                            }
                        }
                    });
                }
            });
        }
    });
}


function deleteUser() {
    $(document).on("click", "#btnDelete", function() {

        let deleteId = $(this).attr("data-id2");

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6s',
            confirmButtonText: 'Sí, Elíminalo!'
        }).then((result) => {
            
            // console.log("Se va a eliminar este usuario");
            
            if (result.isConfirmed) {
                $.ajax({
                    url: "administrator.php",
                    method: "POST",
                    data: { id: deleteId, option: "deleteUser" },
                    success: function(data) {
                        data = $.parseJSON(data);

                        if (data.status === "Se ha eliminado el usuario") {
                            // console.log("Usuario eliminado");
                            $('#table_users').DataTable().ajax.reload();
                            
                            goodNews("Bien hecho", "Se ha eliminado el usuario.");

                        }
                        else if (data.status === "No se pudo eliminar") {
                            // console.log("Usuario no eliminado");
                            emptyFieldsOr("No se pudo eliminar el usuario.");
                        }
                    }
                });
            }
        });
    });
}


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