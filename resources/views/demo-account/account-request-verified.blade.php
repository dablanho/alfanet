<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Alfanet</title>
    <meta content="Admin Dashboard" name="description"/>
    <meta content="Themesbrand" name="author"/>
</head>

<body>

<!-- Begin page -->
<div class="wrapper-page">

    <div class="card">
        <div class="card-body">

            <h3 class="text-center m-0">
                <a href="#go-to-alfanet" class="logo logo-admin"><img src="{{asset('assets/images/logo-light.png')}}" height="30"
                                                                  alt="logo"></a>
            </h3>

            <div class="p-3">

                <div class="form-group row">
                    <h4 for="email">{{ $msg }} </h4>
                    <button type="button" class="form-control btn btn-success font-weight-bolder" onclick="window.location.href = '{{$url}}'">
                        Giriş Yap
                    </button>

                </div>
            </div>

        </div>
    </div>

    <div class="m-t-40 text-center">
        <!--<p>Don't have an account ? <a href="pages-register.html" class=" text-primary"> Signup Now </a> </p>-->
        <p>© Alfanet</p>
    </div>

</div>

</body>
</html>
