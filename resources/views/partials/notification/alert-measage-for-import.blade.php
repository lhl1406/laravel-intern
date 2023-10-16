
@if(! is_null(session('success'))) 
    <input type="checkbox" hidden id="closeMessage">
    <div class="alert {{ session('success') ? 'success' : 'danger' }}">
        <label for="closeMessage">
            <span class="closebtn">&times;</span>
        </label>
        @if(is_array(session('message'))) 
            @php
                $messageList = session('message')
            @endphp
            <div class="d-flex flex-column">
                @foreach($messageList as $key => $messages)
                    @if(is_array($messages)) 
                        @foreach($messages as $key => $message) 
                            <span style="width: 100%"> {{ $message }} </span>
                        @endforeach
                    @endif
                @endforeach
            </div> 
        @else
            <span> {{ session('message') }} </span>
        @endif
    </div>
@endif