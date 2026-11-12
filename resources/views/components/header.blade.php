<header class="header">
    <section class="flex">
        <a href="{{ route('user.all_posts') }}" class="logo">Review App</a>
        <nav class="navbar">
            @auth
                <a href="{{ route('user.all_posts') }}" class="far fa-eye" title="Posts"></a>
                <a href="#" class="far fa-user" id="user-btn" title="Pofile"></a>
            @endauth

            @guest
                <a href="{{ route('user.login') }}" class="fas fa-arrow-right-to-bracket"></a>
                <a href="{{ route('user.register') }}" class="far fa-registered" title="Register"></a>
            @endguest

        </nav>
        @auth
            <div class="profile">
                @if (Auth::user()->image)
                    <img src="{{ asset('uploaded_files/' . Auth::user()->image) }}" class="image" alt="">
                @endif
                <p>{{ Auth::user()->name }}</p>
                <a href="{{ route('user.edit_profile', Auth::id()) }}" class="btn">update profile</a>
                <form action="{{ route('user.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-btn"
                        onclick="return confirm('logout from this website?')">logout</button>
                </form>
            </div>
        @endauth
    </section>
</header>
