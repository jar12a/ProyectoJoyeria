<script>
        // Código para cerrar sesión por inactividad
        let tiempoMaxInactivo = 200000000; // 20 segundos antes de mostrar el modal
        let tiempoParaCerrar = 1000000000; // 10 segundos para cerrar sesión tras el aviso
        let inactivo;
        let cuentaRegresiva;
        let tiempoRestante = 10; // Segundos de cuenta regresiva

        function mostrarModal() {
            document.getElementById("modal").style.display = "flex";
            tiempoRestante = 10;
            document.getElementById("countdown").textContent = tiempoRestante;

            cuentaRegresiva = setInterval(() => {
                tiempoRestante--;
                document.getElementById("countdown").textContent = tiempoRestante;

                if (tiempoRestante <= 0) {
                    clearInterval(cuentaRegresiva);
                    window.location.href = "logout.php"; // Cierra sesión
                }
            }, 1000);
        }

        function reiniciarTiempo() {
            clearTimeout(inactivo);
            clearInterval(cuentaRegresiva);
            document.getElementById("modal").style.display = "none"; // Oculta modal
            inactivo = setTimeout(mostrarModal, tiempoMaxInactivo);
        }

        function continuarSesion() {
            reiniciarTiempo(); // El usuario sigue activo
        }

        document.addEventListener("mousemove", reiniciarTiempo);
        document.addEventListener("keypress", reiniciarTiempo);

        reiniciarTiempo(); // Inicia el temporizador
    </script>