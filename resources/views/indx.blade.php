@include('layouts.app')
<head>
	<title>Dog Coach Francis - Home</title>
</head>

@include('layouts.nav-public')

<div class="parallax-container">
  <div class="parallax">
    <img src="{{ asset('images/banners/b1.jpg') }}">
  </div>
</div>
  <div class="section white">
    <div class="row container">
      <h2 class="header">Dog Coach Francis Inc.</h2>
      <p class="grey-text text-darken-3 lighten-3">Solve your dog's behavior issues with the Philippines' premiere dog behavior consultant Dog Coach Francis. A certified dog behavior consultant and basic obedience trainer by Pet Professionals Guild based in Florida, USA.</p>
      <center>
        <button class="btn modal-trigger" id="login">Login to my account</button>
      </center>
    </div>
  </div>
  <div class="parallax-container">
    <div class="parallax">
      <img src="{{ asset('images/banners/b3.png') }}">
    </div>
  </div>

<form method="post" action="{{ url('/login') }}">
  {{ csrf_field() }}
  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="row">
        <div class="input-field col s12">
          <input id="username" type="text" name="username">
         <label for="username">Username</label>
       </div>
     </div>
     <div class="row">
       <div class="input-field col s12">
         <input id="password" type="password" name="password">
        <label for="password">Password</label>
      </div>
    </div>
    <input value="Y" type="checkbox" name="quick" class="filled-in" id="quick" />
    <label for="quick">Quick Login</label>
    <center>
      <button class="btn modal-action modal-close" id="submit" type="submit">Login</button>
    </center>
    </div>
  </div>
</form>
<script>
$(document).ready(function(){

      $('.parallax').parallax();

      $(document).on("click", "#login", function(){
    			$('.modal').modal();
    			$('#modal1').modal('open');
    	});
});
</script>
