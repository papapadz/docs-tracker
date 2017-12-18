
<div class="row" style="padding:10px 0px 15px 0px; margin-top: -5px;   " >
  <ul class="applink" >
    <li @if($activeLink == 'employee') class="active" @endif ><a href="{{ url('admin/menu') }}" ><strong>Employee</strong></a></li>
    <li @if($activeLink == 'account') class="active" @endif ><a href="{{ url('account/account') }}"><strong>Account</strong></a></li>
    <li @if($activeLink == 'leave') class="active" @endif ><a href="{{ url('/leave') }}"><strong>Leave</strong></a></li>
    <li @if($activeLink == 'leave_request') class="active" @endif ><a href="{{ url('/leave/request') }}"><strong>Leave Request</strong></a></li>
    <li @if($activeLink == 'leave_log') class="active" @endif ><a href="{{ url('/leave/log') }}"><strong>Leave Log</strong></a></li>
  </ul>
</div>  