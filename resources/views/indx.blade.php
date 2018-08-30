<style>
    html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: -webkit-box;
  display: flex;
  -ms-flex-align: center;
  -ms-flex-pack: center;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

</style>
<!DOCTYPE html>
<!-- saved from url=(0051)https://getbootstrap.com/docs/4.0/examples/sign-in/ -->
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="v.1.2">
    <meta name="author" content="Binary Bee IT Solutions and Services">
    
    <!-- Bootstrap core CSS -->
    <link href="{{url('bootstrap-4.0.0/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    </head>

  <body class="text-center">

    <div class="card">
    
    <form  method="post" action="{{ url('/login') }}" class="form-signin">
			@if(session('loginfail'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Login Failed!</strong><br>{{session('loginfail')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
       </div>
      @endif
      {{ csrf_field() }}
      <img class="mb-4" src="{{ asset('images/tesda-logo.png') }}" alt="" width="250" height="250">
      <h3><b>TESDA Ilocos Norte</b></h3>
      <h4 class="mb-4">Document Tracking System</h4>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="text" id="inputEmail" class="form-control mb-3" placeholder="Username" name="username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" name="password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
  </div>
</body>
</html>
<!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/popper.min.js.download') }}"></script>
    <script src="{{ url('assets/js/bootstrap.min.js.download') }}"></script>
