@extends('layouts.app')
<style>
    img {
        width: 15rem;
        height: 15rem;
    }
    p {
        font-size: 1.5rem;
    }
</style>
<head>
	<title>Dog Coach Francis - Pet Profile</title>
</head>

@include('layouts.nav')

@foreach($petinfo as $pet)

<!-- Page Layout here -->
    <div class="row">

      <div class="col s12 m4 l3"> <!-- Note that "m4 l3" was added -->
        <div class="card blue">
              <div class="card-image">
                <img src="@if($pet->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$pet->pet_img) }} @endif">
              </div>
        <div class="card-content">
            <h4><div class="divider"></div>
                <i class="fa fa-paw"></i> {{$pet->pet_name}}<br><div class="divider"></div>
                <div style="background-color:{{$pet->color}};"><i class="fa fa-paint-brush" style="background-color:{{$pet->color}};"></i></div><div class="divider"></div>
                <i class="fa fa-paw"></i> {{$pet->breed}}<div class="divider"></div>
            </h4>
        </div>
        </div>
        <ul class="card collection">
            <li class="collection-item avatar">
              <img src="@if($pet->user_img=='') {{ asset('images/prof-pic.png') }} @else {{ asset('images/parents/'.$pet->user_img) }} @endif" class="circle">
                <span class="title">Pet Parent</span>
                <p>
                   {{$pet->firstname}} {{$pet->lastname}}
                </p>
                 <a href="{{url('admin/userinfo/'.$pet->user_id)}}" class="secondary-content"><i class="fa fa-external-link"></i></a>
            </li>
          </ul>
          @if($pet->on_dogboard=='Y')
          <ul class="card collection">
              <li class="collection-item avatar">
                  <img src="{{ asset('images/info.png') }}" class="circle">
                  <span class="title">On Board</span>
                  <p>
                     Until <bold>@foreach($board as $b) {{\Carbon\Carbon::parse($b->end_date)->format('M j, Y')}} @endforeach</bold>
                  </p>
                   <a href="{{url('admin/set-dogboard/'.$pet->user_id)}}" class="secondary-content"><i class="fa fa-external-link"></i></a>
              </li>
            </ul>
          @endif
      </div>

      <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->

        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Basic Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                  <i class="fa fa-birthday-cake"></i> {{$pet->bday}}<br>

                    @if($pet->gender=='M')
                        <i class="fa fa-mars"></i> Male
                    @else
                        <i class="fa fa-venus"></i> Female
                    @endif <br>

                    @if($pet->collar == 'Y')
                        <i class="fa fa-check-circle"></i> Collar<br>
                    @endif
                    @if($pet->leash == 'Y')
                        <i class="fa fa-check-circle"></i> Leash<br>
                    @endif
                    @if($pet->tag == 'Y')
                        <i class="fa fa-check-circle"></i> Tag<br>
                    @endif
                </p>
                </div>
                <div class="col s6">
                <p>
                    @if($pet->rs == 'Y')
                        @if($pet->gender=='M')
                            <i class="fa fa-check-circle"></i> Neutered
                        @else
                            <i class="fa fa-check-circle"></i> Spayed
                        @endif
                    @else
                        @if($pet->gender=='M')
                            <i class="fa fa-times-circle"></i> Not Neutered
                        @else
                            <i class="fa fa-times-circle"></i> Not Spayed
                        @endif
                    @endif
                    <br>
                    @if($pet->description==null)
                        <i class="fa fa-comment"></i> No description given
                    @else
                        <i class="fa fa-comment"></i> {{ $pet->description }}
                    @endif
                    <br>
                     <i class="fa fa-magic"></i>
                    @if($pet->is_sit == 'N' && $pet->is_stay == 'N' && $pet->is_come == 'N' && $pet->is_down == 'N'&& $pet->oc == null)
                             No known commands yet
                    @else
                       @if($pet->is_sit == 'Y')
                            Sit,
                        @endif
                        @if($pet->is_stay == 'Y')
                            Stay,
                        @endif
                        @if($pet->is_come == 'Y')
                            Come,
                        @endif
                        @if($pet->is_down == 'Y')
                            Down,
                        @endif
                    {{$pet->oc}}
                    @endif
                </p>
                </div>
                <div class="col s12">
                    @if($pet->addinfo!=null)
                        <i class="fa fa-comments"></i> {{$pet->addinfo}}
                    @endif
                </div>
              </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Medical Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                    @if($pet->bp == 'Y')
                        <i class="fa fa-check-circle"></i> Flea and Tick Prevented
                    @else
                        <i class="fa fa-times-circle"></i> Not Flea and Tick Prevented
                    @endif <br>
                </p>
                </div>
                <div class="col s6">
                <p>
                   @if($pet->vac == 'Y')
                        <i class="fa fa-check-circle"></i> On Vaccine
                    @else
                        <i class="fa fa-times-circle"></i> Not on Vaccine
                    @endif
                </p>
                </div>
                <div class="col s12"><p>
                    @foreach($prescription as $presc)
                        <i class="fa fa-medkit"></i> {{ $presc->medicine }} : {{ $presc->dosage }} <br>
                    @endforeach
                </p></div>
              </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Feeding Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                  @if($pet->food!=null)
                        <i class="fa fa-heart"></i> {{$pet->food}}<br>
                  @else
                    <i class="fa fa-heart"></i> Likes no specific Dog Food <br>
                  @endif
                </p>
                </div>
                <div class="col s6">
                <p>
                    <i class="fa fa-comment"></i>
                    @if($pet->feeding_ins!=null)
                        {{$pet->feeding_ins}}
                    @else
                        No specific feeding instruction
                    @endif
                </p>
                </div>
                <div class="col s12"><p>
                    @foreach($feedingtime as $ft)
                        <i class="fa fa-cutlery"></i> {{ $ft->food }} @ {{ $ft->t }} <br>
                    @endforeach
                </p></div>
              </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content orange-text">
              <span class="card-title">Walking Info</span>
              <div class="row">
                <div class="col s6">
                <p>
                    @if($pet->crate == 'Y')
                        <i class="fa fa-check-circle"></i> Crated<br>
                    @endif
                    @if($pet->house == 'Y')
                        <i class="fa fa-check-circle"></i> Run off House<br>
                    @endif
                    @if($pet->outdoors == 'Y')
                        <i class="fa fa-check-circle"></i> Outdoors<br>
                    @endif
                    @if($pet->limited_to!=null)
                        <i class="fa fa-info-circle"></i> Limited to {{$pet->limited_to}}
                    @endif
                </p>
                </div>
                <div class="col s6">
                <p>
                    <i class="fa fa-blind"></i>
                    @if($pet->walk_ins!=null)
                        {{$pet->walk_ins}}<br>
                    @else
                        No walking instructions<br>
                    @endif
                    <i class="fa fa-heart"></i>
                    @if($pet->favtoys!=null)
                        {{$pet->favtoys}}
                    @else
                        No favorite toy
                        @endif
                </p>
                </div>
                <div class="col s12">
                    <p>
                    <i class="fa fa-warning"></i>
                    @if($pet->precautions!=null)
                        {{$pet->precautions}}
                    @else
                        No specific precautions
                    @endif
                    </p>
                </div>
              </div>
            </div>
        </div>

      </div>


@endforeach
