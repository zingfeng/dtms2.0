<html>
<head>
    <title>Feedback Login</title>
    <base href="/">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="theme/frontend/default/css/fontAwesome/css/font-awesome.min.css" media="all">
    <link rel="stylesheet" href="theme/frontend/default/css/bootstrap.min.css" media="all">

    <script type="text/javascript" src="theme/frontend/default/lib/mdb/js/mdb.min.js"></script>
    <script type="text/javascript" src="theme/frontend/default/lib/mdb/js/addons/datatables.js"></script>
    <script type="text/javascript" src="theme/frontend/default/lib/mdb/js/addons/datatables-select.js"></script>


</head>
<body style="background-color: rgb(239, 236, 236)">
<div class="container">
    <div class="row" style="margin-top: 150px">
        <div class="col-sm-12 cold-md-3 col-lg-4">
        </div>
        <div class="col-sm-12 cold-md-6 col-lg-4">
            <div style="padding: 50px; border: 1px solid coral; border-radius: 4px; background-color: white; ">

                <h3>Login Feedback</h3>
                <br>
                <form action="/feedback/login" method="post">
                <div class="form-group div_input_login">
                    <label for="">Tên đăng nhập</label>
                    <input type="text" class="form-control input_login" name="username" id="username" placeholder="Tên đăng nhập">
                </div>
                <div class="form-group div_input_login">
                    <label for="">Mật khẩu</label>

                    <input type="password" class="form-control input_login" name="password" id="password" placeholder="Mật khẩu">
                </div>
                <div>
                    <p class="text-danger">
                        <?php if(isset($error)){
                            echo $error;
                        }
                        ?>
                    </p>
                </div>
                <div class="form-group" >
                    <button type="submit" class="btn btn-success btn-sm">Login</button>
                </div>
                </form>
            </div>

        </div>

    </div>
</div>
</body>
</html>