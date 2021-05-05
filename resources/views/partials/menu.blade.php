    <p style="margin: 0;">Book</p>
    <ul style="display: flex; list-style: none; margin: 0;width: 100%; justify-content: space-between">
        <div style="display: flex">
            <li><a href="/" style="color: white">Accueil</a></li>
            @if(Route::is('book.*') == false)
            @foreach($genres as $id => $genre)
            <li style="margin-left: 20px;"><a href="{{url('genre/' . $id)}}" style="color: white;">{{$genre}}</a></li>
            @endforeach
            @endif
        </div>
        @if(Auth::check())
        <div style="display: flex;">
            <li><a href="{{route('book.index')}}" style="color: white;">Dashboard</a></li>
            <li style="margin-left: 20px;">
                <a href="{{route('logout')}}" onclick="event.preventDefault(); 
            document.getElementById('logout-form').submit();" style="color: white;">Logout</a>
                <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">{{csrf_field()}}</form>
            </li>
            @else
            <li><a href="{{route('login')}}" style="color: white;">Login</a></li>
        </div>
        @endif
    </ul>