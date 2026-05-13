@include('partials.header')

    <section class="py-12 sm:py-20">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6">
            <div class="max-w-md mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-venlury font-bold text-royal-blue mb-2">Welcome Back</h1>
                    <p class="text-gray-600">Sign in to your Divine Raksha account</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-6">
                            <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        @if(request('redirect'))
                            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm" placeholder="your@email.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-royal-blue/20 focus:border-royal-blue transition-colors text-sm" placeholder="••••••••">
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-royal-blue rounded focus:ring-royal-blue">
                                <span class="text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-royal-blue text-white py-3 rounded-full font-semibold hover:bg-deep-royal transition-colors sacred-glow">
                            Sign In
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}{{ request('redirect') ? '?redirect=' . request('redirect') : '' }}" class="font-semibold text-royal-blue hover:underline">Create Account</a>
                        </p>
                    </div>
                </div>

                <!-- Guest Checkout Option -->
                @if(request('redirect') === 'checkout')
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">or</p>
                        <a href="{{ route('checkout.index') }}" class="inline-flex items-center gap-2 mt-2 text-sm font-medium text-gray-600 hover:text-royal-blue transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            Continue as Guest
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

@include('partials.footer')
