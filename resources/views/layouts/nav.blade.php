<style>
nav, .nav-pic{
  height: 3rem;
  line-height: 3rem;
}
.nav-pic{
  width: 3rem;
  padding: .25rem;
}
</style>
<nav>
    <div class="nav-wrapper z-depth-2 orange">
      <a href="#" class="brand-logo">Logo</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars"></i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{ url('admin/home') }}"> Home</a></li>
        <li><a href="{{ url('admin/petinfo') }}">Pets</a></li>
        <li><a href="{{ url('admin/userinfo') }}">Parents</a></li>
        <li><a href="{{ url('admin/staffinfo') }}">Staff</a></li>
        <li><img src="{{ asset('images/prof-pic.png') }}" class="nav-pic circle"></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a href="{{ url('admin/home') }}">Home</a></li>
        <li><a href="{{ url('admin/petinfo') }}">Pets</a></li>
        <li><a href="{{ url('admin/userinfo') }}">Parents</a></li>
        <li><a href="{{ url('admin/staffinfo') }}">Staff</a></li>
        <li><center><img src="{{ asset('images/prof-pic.png') }}" class="nav-pic circle"><center></li>
      </ul>
    </div>
</nav>
