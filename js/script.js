$(document).ready(function(){ 
    $("#register-email").hide();
    $("#register-username").hide();
    $("#register-password").hide();
    $("#register-password-confirmation").hide();
    $("#register-span").hide();
    $("#register-submit").hide();
    $("#registerH").hide();

    $('#datepicker').datepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: 0
        });
    $('#datepicker1').datepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: 0
    });
    var slider = document.getElementById("priceRange");
    var output = document.getElementById("priceVal");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    }

});

function changeDate() {
    var mine = $('#datepicker').datepicker("getDate");
    mine.setDate(mine.getDate()+1);
    $( "#datepicker1" ).datepicker("option", "minDate", mine);
}


function showCreateAccount() {
    $("#login-username").hide()
    $("#login-password").hide()
    $("#login-span").hide()
    $("#login-submit").hide()
    $("#loginH").hide()
    $("#register-email").fadeIn(1000);
    $("#register-username").fadeIn(1000);
    $("#register-password").fadeIn(1000);
    $("#register-password-confirmation").fadeIn(1000);
    $("#register-span").fadeIn(1000);
    $("#register-submit").fadeIn(1000);
    $("#registerH").fadeIn(1000);

};
function showLoginToAccount(){
    $("#register-email").hide();
    $("#register-username").hide();
    $("#register-password").hide();
    $("#register-password-confirmation").hide();
    $("#register-span").hide();
    $("#register-submit").hide();
    $("#registerH").hide();
    $("#login-username").fadeIn(1000);
    $("#login-password").fadeIn(1000);
    $("#login-span").fadeIn(1000);
    $("#login-submit").fadeIn(1000);
    $("#loginH").fadeIn(1000);

};
function resetError() { 
    $("#logerror").empty();
}
function loginAjax() { 
    var form = { 
        username: $("#login-username"),
        password: $("#login-password"),
        token: $("#login-token")
    }
    $.post("userlog.php", {
        username: form.username.val(), password:form.password.val(), token:form.token.val() }, function(messages,status) {
            if(messages==false) { 
                $("#logerror").html("Username or Password is not Correct");
            } else if (messages=="exit") {
                    window.location.href="index.php";
                
            }
            else {
                // userid=
                $("#username").empty();
                $("#loginModal").modal("hide");
                $("#username").html(messages);
            }
        });
}
function registerAjax() { 
    var form = { 
        username: $("#register-username"),
        email:$("#register-email"),
        password: $("#register-password"),
        passconf: $("#register-password-confirmation")
        };
    $.post("register.php", {
        username: form.username.val(), email:form.email.val(), password:form.password.val(), passconf:form.passconf.val() }, function(messages,status) {
            if(messages==false) { 
                $("#logerror").html("Please check your inputs");
            } else if (messages=="exit") {
                    window.location.href="index.php";   
            } else if (messages=="done") {
                $("#logerror").css("color", "#32CD32");
                $("#logerror").html("You have registered successfuly, please login using this form!");
            } else if (messages=="foundDuplicate") {
                $("#logerror").html("A user with this Username already exists. Try logging in.");
            }
        });
}