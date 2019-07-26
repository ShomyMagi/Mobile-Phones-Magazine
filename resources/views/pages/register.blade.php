<html>
    <head>
            <!-- Mobile Specific Meta -->
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <!-- Favicon-->
            <link rel="shortcut icon" href="{{asset('/')}}images/magazine_icon.png">
            <!-- Author Meta -->
            <meta name="author" content="colorlib">
            <!-- Meta Description -->
            <meta name="description" content="">
            <!-- Meta Keyword -->
            <meta name="keywords" content="">
            <!-- meta character set -->
            <meta charset="UTF-8">
            <!-- Site Title -->
            <title>Sign in | Phone reviews</title>
            <link rel="stylesheet" href="{{asset('/')}}css/custom-logreg.css">
            <link rel="stylesheet" href="{{asset('/')}}css/font-awesome.min.css">
            <link rel="stylesheet" href="{{asset('/')}}css/custom-custom.css">
            <link rel="stylesheet" href="{{asset('/')}}css/bootstrap.min.4.3.1.css">
            <style>
                .bs-example
                {
                    margin: 5px 50px;
                    width: 450px;
                }
            </style>
    </head>
    <body>
        @empty(!session('success'))
        <div class="bs-example"> 
        <div class="alert alert-info alert-dismissible fade show">
            <strong>Note!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        </div> 
        @endempty

        @empty(!session('error'))
        <div class="bs-example"> 
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Alert!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        </div>
        @endempty

        @isset($errors)

        <div class="errors">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="bs-example"> 
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Alert!</strong> {{ $error }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    </div>
                @endforeach
            @endif
        </div>

        @endisset
        <div class="login-page">
            <div class="form">
              <form class="register-form" action="{{ asset('register/reg') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                <div class="input-wrapper">
                    <input type="text" name="username" id="tbUsername" placeholder="username" onKeyUp="proveraUsername();"/>
                </div>
                <div class="input-wrapper1">
                    <input type="text" name="ime" id="tbFirstName" placeholder="name" onKeyUp="proveraFirstName();"/>
                </div>
                <div class="input-wrapper2">                                                                                   
                    <input type="text" name="prezime" id="tbLastName" placeholder="surname" onKeyUp="proveraLastName();"/>
                </div>
                <div class="input-wrapper3">                  
                    <input type="text" name="email" id="tbEmail" placeholder="email" onKeyUp="proveraEmail();"/>
                </div>
                <div class="input-wrapper4">
                    <input type="password" name="password" id="tbPassword" placeholder="password" onKeyUp="proveraPassword();"/>
                </div>
                <div class="input-wrapper5">
                    <input type="password" name="password_confirmation" id="tbPassword2" placeholder="repeat password" onKeyUp="proveraPassword2();"/>
                </div>
                <div class="input-wrapper6">
                    <input type="file" name="avatar" id="fileChooser" onchange="return ValidateFileUpload()"/>
                </div>
                <img src="images/noimg.jpg" id="blah" width="50px" height="50px">
                <button type="submit">Register</button>
                <p class="message" id="message">Already registered? <a href="#">Sign In</a></p>
                <p class="message">Return to home page. <a href="{{asset('/')}}">Home</a></p>
              </form>
              <form class="login-form" action="{{ asset('register/log') }}" method="post">
                  {{csrf_field()}}
                <div class="input-wrapper-head">
                    <input type="text" name="username" placeholder="username"/>
                </div>
                <div class="input-wrapper-lock">
                    <input type="password" name="password" placeholder="password"/>
                </div>
                <button type="submit">Login</button>
                <p class="message" id="message">Not registered? <a href="#">Create an account</a></p>
                <p class="message">Return to home page. <a href="{{asset('/')}}">Home</a></p>
              </form>
            </div>
        </div>
            <script src="{{asset('/')}}js/jquery.min.3.3.1.js"></script>
            <script src="{{asset('/')}}js/bootstrap.min.4.3.1.js"></script>
            <script src="{{asset('/')}}js/provera.js"></script>      
    </body>
</html>