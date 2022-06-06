@if (session()->has('meesage'))
    <div>
        <p>
            {{session('message')}}
        </p>
    </div>
    
@endif