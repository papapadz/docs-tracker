@extends('layouts.app')
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

@foreach($userinfo as $user)

<!-- Page Layout here -->
    <div class="row">

      <div class="col s12 m4 l3"> <!-- Note that "m4 l3" was added -->
        <div class="card blue">
              <div class="card-image">
                <img class="profilephoto" src="@if($user->user_img=='') {{ asset('images/prof-pic.png') }} @else {{ asset('images/parents/'.$user->user_img) }} @endif">
              </div>
        <div class="card-content">
            <h5><div class="divider"></div>
                <i class="fa fa-paw"></i> {{$user->firstname}} {{$user->lastname}}<br><div class="divider"></div>
                <i class="fa fa-envelope text-muted"></i> {{$user->email}} <div class="divider"></div>
                    @if($user->gender=='M')
                        <i class="fa fa-mars text-muted"></i> Male
                    @else
                        <i class="fa fa-venus text-muted"></i> Female
                    @endif
                <div class="divider"></div>
                <i class="fa fa-birthday-cake text-muted"></i> {{$user->bday}}<div class="divider"></div>
            </h5>
        </div>
        </div>
      </div>

      <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->
         
        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Contact Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                    <i class="fa fa-phone"></i> {{$user->home_phone}}<br>
                    <i class="fa fa-mobile"></i> {{$user->alt_phone}}
                </p>
                </div>
                <div class="col s6">
                <p>
                   <i class="fa fa-home"></i> {{$user->address}}
                </p>
                </div>
              </div>
            </div>
        </div>
          
        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Additional Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                    <i class="fa fa-briefcase"></i> {{$user->occupation}}<br>
                    @if($user->is_attended=='Y')
                        <i class="fa fa-check-circle"></i> Attended Dog Obedience Class before
                    @else
                        <i class="fa fa-times-circle"></i> Not yet Attended any Dog Obedience Class
                    @endif
                </p>
                </div>
                <div class="col s6">
                <p>
                   <i class="fa fa-comment"></i> Heard DCF from {{$user->heard_of}} <br>
                   <i class="fa fa-eye"></i> {{$user->expectations}}
                </p>
                </div>
              </div>
            </div>
        </div>
          
        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">My Pets</span>
                <center>
                @foreach($userpets as $pet)
                    <a href="{{url('admin/petinfo/'.$pet->pet_id)}}">{{$pet->pet_name}}<img class="petphoto circle" src="@if($pet->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$pet->pet_img) }} @endif"></a> &nbsp;
                @endforeach
                </center>
            </div>
        </div>  
         
      </div>
@endforeach