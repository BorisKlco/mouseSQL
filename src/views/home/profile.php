<!-- Profile Content -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">User Profile</h1>
        <p class="text-gray-600">Manage your account settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Information -->
        <div class="lg:col-span-1 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Account Information</h2>
            </div>
            <div class="px-6 py-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Username</label>
                        <div class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars(user('username')); ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <div class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo htmlspecialchars(user('email')); ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Member Since</label>
                        <div class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo date('F j, Y', strtotime(user('created_at'))); ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Last Login</label>
                        <div class="mt-1 text-lg font-medium text-gray-900">
                            <?php echo user('last_login') ? date('F j, Y \a\t g:i A', strtotime(user('last_login'))) : 'Never'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Change Password</h2>
            </div>
            <div class="px-6 py-4">
                <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        <p class="text-gray-500 text-xs mt-1">Must be at least 6 characters long</p>
                    </div>

                    <div class="mb-6">
                        <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <?= csrf() ?>
                    <div class="flex items-center justify-between">
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Options -->
        <div class="lg:col-span-3 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Account Management</h2>
            </div>
            <div class="px-6 py-4">
                <div class="flex flex-wrap gap-4">
                    <a href="/dashboard" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Dashboard
                    </a>
                    <form action="/delete_acc" method="POST">
                        <?= csrf() ?>
                        <button
                            onclick="confirm('Are you sure you want to delete your account? This action cannot be undone.')"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>