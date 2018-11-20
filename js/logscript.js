$(document).ready(function(){ 
    $("#register-email").hide();
    $("#register-password").hide();
    $("#register-password_confirmation").hide();
    $("#register-span").hide();
    $("#register-submit").hide();
    $("#registerH").hide();



});


function showCreateAccount() {
    $("#login-email").hide()
    $("#login-password").hide()
    $("#login-span").hide()
    $("#login-submit").hide()
    $("#loginH").hide()
    $("#register-email").fadeIn(1000);
    $("#register-password").fadeIn(1000);
    $("#register-password_confirmation").fadeIn(1000);
    $("#register-span").fadeIn(1000);
    $("#register-submit").fadeIn(1000);
    $("#registerH").fadeIn(1000);

};
function showLoginToAccount(){
    $("#register-email").hide();
    $("#register-password").hide();
    $("#register-password_confirmation").hide();
    $("#register-span").hide();
    $("#register-submit").hide();
    $("#registerH").hide();
    $("#login-email").fadeIn(1000);
    $("#login-password").fadeIn(1000);
    $("#login-span").fadeIn(1000);
    $("#login-submit").fadeIn(1000);
    $("#loginH").fadeIn(1000);

};

function loginAjax() { 
    var form = { 
        username: $("#login-username"),
        password: $("#login-password")
    }
    $.post("userlog1.php", {
        username: form.username.val(), password:form.password.val() }, function(messages,status) {
            if(messages==false) { 
                $("#error").html("Username or Password is not Correct");
            } else if (messages=="exit") {
                window.location.href="index.php"
            }
            else {
                $("#username").empty();
                $("#username").html(messages);
            }
        });
}