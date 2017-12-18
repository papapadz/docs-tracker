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
                                        <th>Name</th>
                                        <th>Home Phone #</th>
                                        <th>Alternative Phone #</th>
                                        <th>Address</th>
                                        <th>
                                          <a id="haa" class="waves-effect waves-teal btn-floating modal-trigger blue" ><i class="fa fa-search"></i></a>
                                          <a id="add" class="waves-effect waves-teal btn-floating green" href="{{ url('/admin/add-petparent') }}" ><i class="fa fa-plus"></i></a>
                                        </th>
                                    </tr>
                                </thead>
                                    <tbody>
                                       @forelse($userlist as $users)
                                        <tr>
                                            <td><img src="@if($users->user_img=='') {{ asset('images/prof-pic.png') }} @else {{ asset('images/parents/'.$users->user_img) }} @endif" class="circle"> </td>
                                            <td><a href="userinfo/{{$users->user_id}}">{{$users->lastname}}, {{$users->firstname}}</a></td>
                                            <td>{{$users->home_phone}}</td>
                                            <td>{{$users->alt_phone}}</td>
                                            <td>{{$users->address}}</td>
                                            <td>
                                                <a style="color:red;" href="#"><em class="fa fa-close"></em> Delete</a>
                                            </td>
                                        </tr>
                                      @empty
                                        <tr>
                                          <td colspan="6" style="color:red" >No records found.</td>
                                        </tr>
                                      @endforelse
                                    <tr>
                                        <td colspan="6">
                                        {{$userlist->links()}}
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
        <form id="formsearch" action="{{ url('/admin/userinfo') }}" method="POST">
          {{ csrf_field() }}
            <div class="input-field">
                <p>
                <input id="key" type="text" class="validate" name="key">
                <label for="key">Pet Parents Name</label>
                <button class="btn" type="submit">Search</button>
                </p>
            </div>
        </form>
    </div>
  </div>
