@include('layouts.app')
<style>
    img {
        height: 2rem;
        width: 2rem;
        align-items: center;
    }
</style>
<script>
$(document).ready(function() {

    $(document).on("click", "#haa", function(){
        $('.modal').modal();
        $('#modal1').modal('open');
    });

});
</script>

<head>
	<title>Dog Coach Francis - Pets</title>
</head>

@include('layouts.nav')

<div class="container">

<table class="responsive-table striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name of Dog</th>
                                        <th>Breed</th>
                                        <th>Color</th>
                                        <th>Age</th>
                                        <th>Pet Owner</th>
                                        <th>
                                          <a id="haa" class="waves-effect waves-teal btn-floating modal-trigger blue" ><i class="fa fa-search"></i></a>
                                          <a id="add" class="waves-effect waves-teal btn-floating green" href="{{ url('/admin/add-pet') }}" ><i class="fa fa-plus"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                    <tbody>
                                       @forelse($petlist as $pets)
                                        <tr>
                                            <td><img src="@if($pets->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$pets->pet_img) }} @endif" class="circle"> </td>
                                            <td><a style="color:primary;" href="{{url('admin/petinfo/'.$pets->pet_id)}}">{{$pets->pet_name}}</a></td>
                                            <td><a style="color:primary;" href="{{url('admin/petinfo/breed/'.$pets->breed_id)}}">{{$pets->breed}}</a></td>
                                            <td style="background-color:{{$pets->color}};"></td>
                                            <td>
                                                @if($pets->yrs_old > 0)
                                                    {{$pets->yrs_old}} yrs &amp; {{$pets->mos_old}} mos
                                                @else
                                                    {{$pets->mos_old}} mos
                                                @endif
                                            </td>
                                            <td><a style="color:primary;" href="{{url('admin/userinfo/'.$pets->user_id)}}">{{$pets->firstname}} {{$pets->lastname}}</a></td>
                                            <td>
                                                <a href="{{ url('admin/set-dogboard/'.$pets->pet_id) }}" class="tooltipped" data-tooltip="@if( $pets->on_dogboard=='Y') Remove from Dog Boarding @else Put to Dog Boarding @endif">@if( $pets->on_dogboard=='Y')<i class="fa fa-star" style="color:green"></i> @else <i class="fa fa-star-o"></i> @endif</a>&nbsp;
                                                <a class="tooltipped" data-tooltip="Edit" href="{{ url('admin/edit-petinfo/'.$pets->pet_id) }}"><i class="fa fa-pencil-square-o"></i></a>
                                            </td>
                                        </tr>
                                      @empty
                                        <tr>
                                          <td colspan="7" style="color:red" >No records found.</td>
                                        </tr>
                                      @endforelse
                                        <tr>
                                          <td colspan="7"><center> {{$petlist->links()}} </center></td>
                                        </tr>
                                    </tbody>
                                </table>
</div>
<!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h5><i class="fa fa-search"></i>Search</h5>
        <form id="formsearch" action="{{ url('/admin/petinfo') }}" method="POST">
          {{ csrf_field() }}
            <div class="input-field">
                <p>
                <input id="key" type="text" class="validate" name="key">
                <label for="key">Dog's Name</label>
                <button class="btn" type="submit">Search</button>
                </p>
            </div>
        </form>
    </div>
  </div>
