@auth()
@include('layouts.navbars.navs.magazine')
@endauth

@guest()
@include('layouts.navbars.navs.guest')
@endguest