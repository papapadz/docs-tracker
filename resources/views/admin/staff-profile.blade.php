@include('layouts.app')
<style>
    img.profilephoto {
        width: 15rem;
        height: 15rem;
    }
    img.petphoto {
        width: 10rem;
        height: 10rem;
    }
    p {
        font-size: 1.5rem;
    }
</style>
<head>
	<title>Dog Coach Francis - Pet Profile</title>
</head>

@include('layouts.nav')

@foreach($staffinfo as $staff)

<!-- Page Layout here -->
    <div class="row">

      <div class="col s12 m4 l3"> <!-- Note that "m4 l3" was added -->
        <div class="card blue">
              <div class="card-image">
                <img class="profilephoto" src="@if($staff->user_img=='') {{ asset('images/prof-pic.png') }} @else {{ asset('images/staffs/'.$staff->user_img) }} @endif">
              </div>
        <div class="card-content">
            <h5><div class="divider"></div>
                <i class="fa fa-paw"></i> {{$staff->nickname}}<br><div class="divider"></div>
                <i class="fa fa-phone"></i> {{$staff->home_phone}} <div class="divider"></div>
                    @if($staff->gender=='M')
                        <i class="fa fa-mars text-muted"></i> Male
                    @else
                        <i class="fa fa-venus text-muted"></i> Female
                    @endif
                <div class="divider"></div>
                <i class="fa fa-birthday-cake text-muted"></i> {{$staff->bday}}<div class="divider"></div>
            </h5>
        </div>
        </div>
      </div>

      <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->

        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Basic Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                  <i class="fa fa-user"></i> {{$staff->firstname}} {{$staff->lastname}} <br>
                  <i class="fa fa-calendar"></i> {{$staff->yrs_old}} yrs old
                </p>
                </div>
                <div class="col s6">
                <p>
                   <i class="fa fa-home"></i> {{$staff->address}}
                </p>
                </div>
              </div>
            </div>
        </div>

      </div>
@endforeach
