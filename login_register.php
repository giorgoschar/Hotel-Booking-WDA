<?php 
    $token = md5(rand(20,25));
    $_SESSION["token"] = $token;

?>
<html>
    <!-- Bootstrap --->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <div class="modal fade login" id="loginModal">
        <div class="modal-dialog login">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="loginH">Login</h4>
                    <h4 class="modal-title" id="registerH">Register</h4>
                </div>
                <div class="modal-body">
                    <div id="logerror"></div>
                    <div class="formLogin">
                            <input id="login-username" onfocus="resetError()" class="form-control" type="text" placeholder="Username" name="username">
                            <input id="login-password" onfocus="resetError()" class="form-control" type="password" placeholder="Password" name="password">
                            <input id="login-token" type="hidden" value="<?php echo $token;?>">
                            <input class="btnLoginRegister" id="login-submit" type="submit" value="Login" onclick="loginAjax()">
                            <span id="login-span" >Looking to <a href="javascript:showCreateAccount()">create an account?</a></span>
                    </div>
                    <div class="formRegister">
                            <input id="register-email" class="form-control" type="email" placeholder="Email" name="email" required>
                            <input id="register-username" class="form-control" type="text" placeholder="Username" name="username" required>
                            <input id="register-password" class="form-control" type="password" placeholder="Password" name="password" required>
                            <input id="register-password-confirmation" class="form-control" type="password" placeholder="Re-type Password" name="password_confirmation">
                            <input class="btnLoginRegister" id="register-submit" type="submit" onclick="registerAjax()" value="Create account">
                            <span id="register-span">Already have an account? <a href="javascript:showLoginToAccount()">Login</a></span>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <div class="modal fade" id="modalNeedToLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalbookedLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <p>You need to be logged in in order to access this feature</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</html>
