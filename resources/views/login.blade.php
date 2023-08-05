<x-layout>

    <div class="login-container">
        <form class="login" action="{{ route('login') }}" method="post">
            <div class="login-field">
                <input name="username" type="text" placeholder="Username" autofocus>
            </div>
            <div class="login-field">
                <input name="password" type="password" placeholder="Password">
            </div>
            <div class="login-button">
                <button type="submit">Log In</button>
            </div>
            @csrf
        </form>
    </div>

</x-layout>
