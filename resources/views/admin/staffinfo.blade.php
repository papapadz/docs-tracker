@include('layouts.app')
<style>
    img {
        height: 2rem;
        width: 2rem;
        align-items: center;
    }
</style>

<script>
$(document).on("click", "#haa", function(){
    $('.modal').modal();
    $('#modal1').modal('open');
});
</script>

<head>
	<title>Dog Coach Francis - Pet Parents</title>
</head>

@include('layouts.nav')

<div class="container">

<table class="responsive-table striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Nickname</th>
                                        <th>Phone #</th>
                                        <th>Address</th>
                                        <th><a id="haa" class="waves-effect waves-teal btn-floating modal-trigger blue" ><i class="fa fa-search"></i></a>
                                          <a id="add" class="waves-effect waves-teal btn-floating green" href="{{ url('/admin/add-staff') }}" ><i class="fa fa-plus"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                    <tbody>
                                       @forelse($stafflist as $staff)
                                        <tr>
                                            <td><img src="@if($staff->user_img=='') {{ asset('images/prof-pic.png') }} @else {{ asset('images/staffs/'.$staff->user_img) }} @endif" class="circle"> </td>
                                            <td><a href="staffinfo/{{$staff->user_id}}">{{$staff->nickname}}</a></td>
                                            <td>{{$staff->home_phone}}</td>
                                            <td>{{$staff->address}}</td>
                                            <td>
                                                <!-- <a style="color:red;" href="#"><em class="fa fa-close"></em> Delete</a> -->
                                            </td>
                                        </tr>
                                      @empty
                                        <tr>
                                          <td colspan="5" style="color:red" >No records found.</td>
                                        </tr>
                                      @endforelse
                                    <tr>
                                        <td colspan="5">
                                        {{$stafflist->links()}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

</div>
</div>
<!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h5><i class="fa fa-search"></i>Search</h5>
        <form id="formsearch" action="{{ url('/admin/staffinfo') }}" method="POST">
          {{ csrf_field() }}
            <div class="input-field">
                <p>
                <input id="key" type="text" class="validate" name="key">
                <label for="key">Staff's Name</label>
                <button class="btn" type="submit">Search</button>
                </p>
            </div>
        </form>
    </div>
  </div>
