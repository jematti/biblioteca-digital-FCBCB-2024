import {Dropzone} from "dropzone";

Dropzone.autoDiscover = false;

window.addEventListener('DOMContentLoaded', () => {
    const dropzone = new Dropzone("#dropzone", {
        dictDefaultMessage: "Sube tu imagen del libro",
        acceptedFiles: ".png,.jpg,.jpeg,.gif",
        addRemoveFile: "Borrar Archivo",
        addRemoveLinks: true,
        dictRemoveFile: "Borrar Archivo",
        maxFiles: 1,
        uploadMultiple: false,
    });

    dropzone.on("sending", function (file, xhr, formData) {
        console.log(formData);
    });

    dropzone.on("success", function (file, response) {
        console.log(response);
    });

    dropzone.on("error",function (file,message){
        console.log(message);
    });

    dropzone.on("removedfile",function (file){
        console.log("ARCHIVO BORRADO");
    })
});



