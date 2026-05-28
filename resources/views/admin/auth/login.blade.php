<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Divine Raksha</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'royal-blue': '#1e3a8a',
                        'deep-royal': '#1e40af',
                        'sacred-gold': '#d4af37',
                        'divine-red': '#dc2626',
                        'pure-white': '#ffffff',
                        'soft-grey': '#f8fafc'
                    },
                    fontFamily: {
                        'venlury': ['Playfair Display', 'serif'],
                        'coolvetica': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .om-background {
            background: linear-gradient(135deg, #1e3a8a 0%, #011455 100%);
            position: relative;
        }
        .om-background::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("{{ asset('images/om.svg') }}");
            background-size: 60px 60px;
            background-repeat: repeat;
            opacity: 0.05;
            pointer-events: none;
        }
        .sacred-glow {
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.15);
        }
    </style>
</head>
<body class="font-coolvetica">
    <div class="min-h-screen om-background flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md relative z-10">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo-divine-raksha.webp') }}" alt="Divine Raksha" class="h-20 w-auto mx-auto mb-4">
                <h1 class="text-2xl font-venlury font-bold text-pure-white">Admin Portal</h1>
                <p class="text-pure-white/60 text-sm mt-1">Sacred Management Console</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl sacred-glow p-8">
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors text-sm"
                                   placeholder="admin@divineraksha.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-royal-blue focus:border-royal-blue transition-colors text-sm"
                                   placeholder="Enter your password">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-royal-blue border-gray-300 rounded focus:ring-royal-blue">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            class="w-full bg-royal-blue hover:bg-deep-royal text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <p class="text-center text-pure-white/40 text-xs mt-8">
                &copy; {{ date('Y') }} Divine Raksha. Sacred Administration.
            </p>
        </div>
    </div>
</body>
</html>
