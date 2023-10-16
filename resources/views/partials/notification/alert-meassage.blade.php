@php
    $type = $type ?? '';
@endphp
<input type="checkbox" hidden id="closeMessage">
<div class="alert {{$type}}">
    <label for="closeMessage">
        <span class="closebtn">&times;</span>
    </label>
    <span> {{$message}} </span>
</div>