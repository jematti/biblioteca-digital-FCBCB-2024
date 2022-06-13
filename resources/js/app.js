import {Dropzone} from "dropzone";

Dropzone.autoDiscover = false;

window.addEventListener('DOMContentLoaded', () => {
    const dropzone = new Dropzone("#dropzone", {
        dictDefaultMessage: "Sube tu imagen del libro",
        acceptedFiles: ".png,.jpg,.jpeg,.gif",
        addRemoveLinks: true,
        dictRemoveFile: "Borrar Archivo",
        maxFiles: 1,
        uploadMultiple: false,

        // funcion para no borrar imagen si se actualiza el formulario
        init: function () {
            if(document.querySelector('[name="imagen"]').value.trim()) {
                //crear un objeto imagen temporal con tamaño y nombre
                const imagenPublicada = {}
                imagenPublicada.size = 1000;
                imagenPublicada.name = document.querySelector('[name="imagen"]').value;

                //funciones de dropzone para pasar la img publicada
                this.options.addedfile.call(this, imagenPublicada);
                // extraer la imagen publicada previamente
                this.options.thumbnail.call(this, imagenPublicada, ` /uploads/${imagenPublicada.name}`);
                //clases de dropzone
                imagenPublicada.previewElement.classList.add(
                    'dz-success',
                    'dz-complete');
            }
        }
    });

    //respuesta de subida de imagen
    dropzone.on("success", function (file, response) {
        document.querySelector('[name="imagen"]').value = response.imagen;
    });


    dropzone.on("removedfile",function (){
        // resetar el campo imagen si no se usa
        document.querySelector('[name="imagen"]').value = "";
    })
});



