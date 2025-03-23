<!-- Modal de aviso de cierre de sesión -->
<div class="modal fade" id="modalCierreSesion" tabindex="-1" aria-labelledby="modalCierreSesionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCierreSesionLabel">Aviso de Cierre de Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Se cerrará la sesión en <span id="countdown">10</span> segundos por inactividad.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="continuarSesion()">Continuar Sesión</button>
            </div>
        </div>
    </div>
</div>

<script>
    let tiempoMaxInactivo = 2000000; // 20 segundos antes de mostrar el modal (cada mil milisegundo es un segundo)
    let tiempoParaCerrar = 10000; // 10 segundos para cerrar sesión tras el aviso
    let inactivo;
    let cuentaRegresiva;
    let tiempoRestante = 10;
    let modalSesion; // Instancia del modal Bootstrap

    document.addEventListener("DOMContentLoaded", function () {
        let modalElement = document.getElementById("modalCierreSesion");
        if (modalElement) {
            modalSesion = new bootstrap.Modal(modalElement); // Inicializa el modal
        }
        reiniciarTiempo(); // Inicia el temporizador al cargar la página
    });

    function mostrarModal() {
        if (modalSesion) {
            modalSesion.show();
            tiempoRestante = 10;
            document.getElementById("countdown").textContent = tiempoRestante;

            cuentaRegresiva = setInterval(() => {
                tiempoRestante--;
                document.getElementById("countdown").textContent = tiempoRestante;

                if (tiempoRestante <= 0) {
                    clearInterval(cuentaRegresiva);
                    window.location.href = "/ProyectoJoyeria/confi/logout.php"; // Cierra sesión
                }
            }, 1000);
        } else {
            console.error("No se encontró el modal de cierre de sesión.");
        }
    }

    function reiniciarTiempo() {
        clearTimeout(inactivo);
        clearInterval(cuentaRegresiva);

        if (modalSesion) {
            modalSesion.hide(); // Oculta el modal si está abierto
        }

        inactivo = setTimeout(mostrarModal, tiempoMaxInactivo);
    }

    function continuarSesion() {
        reiniciarTiempo(); // El usuario sigue activo
    }

    document.addEventListener("mousemove", reiniciarTiempo);
    document.addEventListener("keypress", reiniciarTiempo);
</script>