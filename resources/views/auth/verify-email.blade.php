@include('partials.header')

    <section class="py-16 sm:py-24">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="max-w-md mx-auto text-center">
                <div class="w-20 h-20 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-venlury font-bold text-royal-blue mb-4">Verify Your Email</h1>
                <p class="text-gray-600 mb-6">We've sent a verification link to <strong>{{ Auth::user()->email }}</strong>. Please check your inbox and click the link to verify your email address.</p>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-6">
                        <p class="text-sm text-green-600">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-royal-blue text-white font-semibold rounded-full hover:bg-deep-royal transition-colors">
                        Resend Verification Email
                    </button>
                </form>

                <p class="mt-6 text-sm text-gray-500">Didn't receive the email? Check your spam folder or click above to resend.</p>
            </div>
        </div>
    </section>

@include('partials.footer')
