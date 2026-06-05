<x-layouts::auth :title="__('Admin Login')">
    @if (session('status'))
        <p class="auth-status-msg">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="auth-form">
        @csrf

        <label class="auth-label" for="email">Email address</label>
        <input class="auth-input" id="email" name="email" type="email"
               value="{{ old('email') }}" required autofocus autocomplete="email"
               placeholder="admin@bellara.ngome.tech">

        <label class="auth-label" for="password">Password</label>
        <input class="auth-input" id="password" name="password" type="password"
               required autocomplete="current-password" placeholder="••••••••">

        <div class="auth-row">
            <label class="auth-check-label">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="button button-primary button-full" style="margin-top:0.4rem;">
            Sign in to Admin
        </button>
    </form>
</x-layouts::auth>
