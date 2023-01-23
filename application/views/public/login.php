<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_header_script.php"); ?>
</head>

<body>
    <section class="container-fluid">
        <div class="login-content row">
            <div class="col-md-7 col-7 login-frame">
                <div class="login-frame-overlay"></div>
                <div class="login-frame-info">
                    <h2>Integrated PLKK Rates</h2>
                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
                </div>
            </div>
            <div class="col-md-5 col-5 login-form">
                <div class="login-form-box">
                    <h4>Selamat Datang</h4>
                    <h6>Silahkan masuk untuk menggunakan aplikasi</h6>
                    <form name="login-form" id="login-form" class="mt-5" novalidate="novalidate">
                        <div class="form-group mb-5">
                            <label for="username_login">Login ID / Username</label>
                            <div class="input-group mb-3">
                                <input type="text" name="username_login" id="username_login" class="form-control" value="" placeholder="Masukkan Login ID" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <label for="password">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password_login" id="password_login" class="form-control" value="" placeholder="Masukkan Password" autocomplete="off" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
                                        <span class="fas fa-eye"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-danger col-12" id="submit_login" disabled="disabled"><i class="fas fa-sign-in-alt"></i>Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?PHP include(APPPATH . "views/layout/html_footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script type="text/javascript">
        $(".fa-eye-slash").click(
            function() {
                $(".fa-eye").show();
                $(".fa-eye-slash").hide();
                $("#password_login").prop("type", "text");
            }
        );
        $(".fa-eye").click(
            function() {
                $(".fa-eye").hide();
                $(".fa-eye-slash").show();
                $("#password_login").prop("type", "password");
            }
        );
        $("#username_login").keyup(function() {
            var password_login = $("#password_login").val();
            var username_login = $("#username_login").val();

            if (username_login != "" && password_login != "") {
                $("#submit_login").removeAttr("disabled");
            }
        });

        $("#password_login").keyup(function() {
            var password_login = $("#password_login").val();
            var username_login = $("#username_login").val();

            if (username_login != "" && password_login != "") {
                $("#submit_login").removeAttr("disabled");
            }
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();
                    $.ajax({
                        url: '<?php echo base_url("user/dologin"); ?>',
                        type: "POST",
                        data: $("#login-form").serializeArray(),
                        dataType: "JSON",
                        success: function(response) {
                            if (response.result == 200) {
                                $('.overlay-loading').hide();
                                window.location.href = "<?php echo base_url("home   "); ?>";
                            } else {
                                $('.overlay-loading').hide();
                                show_notif("error", response.message)
                            }
                        },
                        error: function(error) {
                            $('.overlay-loading').hide();
                            show_notif("error", "Gagal login! Ulangi beberapa saat lagi")
                        }
                    });
                }
            });
            $('#login-form').validate({
                rules: {
                    username_login: {
                        required: true
                    },
                    password_login: {
                        required: true
                    }
                },
                messages: {
                    username_login: {
                        required: "Silahkan masukkan Login ID"
                    },
                    password_login: {
                        required: "Silahkan masukkan Password"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>