<div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-5 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Iniciar Sesion</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <form method="POST" action="login.php?accion=login">
                    <div class="form-floating mb-3">
                        <input name="correo" type="email" class="form-control rounded-4" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Correo Electronico</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="contrasena" type="password" class="form-control rounded-4" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Contraseña</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit">Sign up</button>
                    <br>
                    <br>
                    <a href="login.php?accion=olvido">Olvido Su Contraseña?</a>
                </form>
            </div>
        </div>
    </div>
</div>