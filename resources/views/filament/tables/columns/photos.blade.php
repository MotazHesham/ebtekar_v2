<div>
    @if(json_decode($getState()) != null && json_decode($getState())[0])
        <img src="{{image_asset(json_decode($getState())[0])}}" width="80" height="80" alt="">
    @endif
</div>
