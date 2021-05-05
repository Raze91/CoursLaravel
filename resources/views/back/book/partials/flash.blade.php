@if(Session::has('message'))
<div>
    <p>{{Session::get('message')}}</p>
</div>
@endif