    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-slate-400 to-blue-500 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Free PostgreSQL Database Service</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Get your own PostgreSQL database instance instantly. Perfect for development, testing, and small projects.</p>
            <?php if (!logged()): ?>
                <div class="space-x-4">
                    <a href="/register" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Get Started Free</a>
                    <a href="#features" class="border-2 border-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">Learn More</a>
                </div>
            <?php else: ?>
                <a href="/dashboard" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Why Choose Our Service?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Instant Setup</h3>
                    <p class="text-gray-600">Get your PostgreSQL database up and running in seconds after registration. No waiting, no complicated setup.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure & Isolated</h3>
                    <p class="text-gray-600">Each user gets their own isolated database environment with restricted access for maximum security.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                    <div class="text-blue-600 text-3xl mb-4">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Developer Friendly</h3>
                    <p class="text-gray-600">Full PostgreSQL compatibility with connection details provided for easy integration with your applications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-blue-600 font-bold text-xl">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sign Up</h3>
                    <p class="text-gray-600">Create your free account in under a minute</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-blue-600 font-bold text-xl">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Get Database</h3>
                    <p class="text-gray-600">We automatically create your PostgreSQL instance</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-blue-600 font-bold text-xl">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Connect</h3>
                    <p class="text-gray-600">Use provided credentials to connect your application</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-blue-600 font-bold text-xl">4</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Develop</h3>
                    <p class="text-gray-600">Start building your application with PostgreSQL</p>
                </div>
            </div>
        </div>
    </section>