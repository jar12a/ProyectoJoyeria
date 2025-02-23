<footer class="footer">
    <div class="container container-footer">
        <div class="menu-footer">
            <div class="contact-info">
                <p class="title-footer">Información de Contacto</p>
                <ul>
                    <li>Dirección: Danlí, El Paraíso, Honduras.</li>
                    <li>Teléfono: + 504 9667-7273</li>
                    <li>Fax: xxxxxx</li>
                    <li>Email: ImperialGems@support.com</li>
                </ul>
                <div class="social-icons">
                    <span class="facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </span>
                    <span class="twitter">
                        <i class="fa-brands fa-twitter"></i>
                    </span>
                    <span class="youtube">
                        <i class="fa-brands fa-youtube"></i>
                    </span>
                    <span class="pinterest">
                        <i class="fa-brands fa-pinterest-p"></i>
                    </span>
                    <span class="instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </span>
                </div>
            </div>

            <div class="information">
                <p class="title-footer">Información</p>
                <ul>
                    <li><a href="<?= 'http://localhost/ProyectoJoyeria/Contacto.html' ?>">Acerca de Nosotros</a></li>
                    <li><a href="#">Información Delivery</a></li>
                    <li><a href="#">Políticas de Privacidad</a></li>
                    <li><a href="#">Términos y condiciones</a></li>
                    <li><a href="<?= 'http://localhost/ProyectoJoyeria/Contacto.html' ?>">Contáctanos</a></li>
                </ul>
            </div>

            <div class="my-account">
                <p class="title-footer">Mi cuenta</p>
                <ul>
                    <li><a href="#">Mi cuenta</a></li>
                    <li><a href="#">Historial de órdenes</a></li>
                    <li><a href="#">Lista de deseos</a></li>
                    <li><a href="#">Boletín</a></li>
                    <li><a href="#">Reembolsos</a></li>
                </ul>
            </div>

            <div class="newsletter">
                <p class="title-footer">Boletín informativo</p>
                <div class="content">
                    <p>
                        Suscríbete a nuestra página ahora y mantente al día con nuevas colecciones y ofertas exclusivas.
                    </p>
                    <form method="post" action="suscribirse.php">
                        <input type="email" name="email" placeholder="Ingresa el correo aquí..." required>
                        <button type="submit">Suscríbete</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>
                Desarrollado por Alex &copy; <?= date("Y"); ?>. Todos los derechos reservados.
            </p>
            <img src="img/payment.png" alt="Pagos">
        </div>
    </div>
</footer>
