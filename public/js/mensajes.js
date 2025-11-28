document.addEventListener("DOMContentLoaded", function () {
    const botonesVer = document.querySelectorAll(".btn-accion");

    botonesVer.forEach(boton => {
        boton.addEventListener("click", async function () {
            const item = this.closest(".notificacion-item");
            const h5 = item.querySelector("h5");
            const idMensaje = this.dataset.id; // <-- aquí obtenemos el ID

            // 🔹 1. Llamar al backend para marcar como visto
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/mensaje-visto/${idMensaje}`, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    }
                });

                const data = await response.json();
                console.log(data);

                if (data.status === "success") {
                    console.log("Mensaje marcado como visto");

                    // 🔹 Cambiar el estilo del mensaje (por ejemplo quitar clase "no-leida")
                    item.classList.remove("no-leida");
                    item.classList.add("leida");
                }
            } catch (error) {
                console.error("Error al marcar como visto:", error);
            }

            // 🔹 2. Mostrar la información en el modal
            let nombreCompleto = h5?.innerText.replace("Mensaje enviado a", "").trim() || "Sin nombre";
            const asunto = "Mensaje enviado";
            const contenido = item.querySelector("p")?.innerText.trim() || "Sin contenido";

            document.getElementById("mensajeNombre").innerText = nombreCompleto;
            document.getElementById("mensajeAsunto").innerText = asunto;
            document.getElementById("mensajeContenido").innerText = contenido;

            // 🔹 3. Mostrar el modal
            const modalEl = document.getElementById("modalVerMensaje");
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });
    });
});