<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
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
            <img src="<?= '/ProyectoJoyeria/img/payment.png' ?>" alt="Pagos">
        </div>
    </div>
</footer>

<style>
    @media (max-width: 768px) {
        .container-footer {
            padding: 2rem;
        }
        .menu-footer {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .contact-info, .information, .my-account, .newsletter {
            text-align: center;
        }
        .contact-info ul, .information ul, .my-account ul {
            padding: 0;
        }
        .contact-info ul li, .information ul li, .my-account ul li {
            font-size: 1.2rem;
        }
        .social-icons {
            justify-content: center;
        }
        .content p {
            font-size: 1.2rem;
        }
        .content input {
            width: 100%;
        }
        .content button {
            width: 100%;
        }
        .copyright {
            flex-direction: column;
            text-align: center;
        }
        .copyright p {
            margin-bottom: 1rem;
        }
    }
</style>
<script src="https://kit.fontawesome.com/45b2b3afef.js" crossorigin="anonymous"></script>
</html>

