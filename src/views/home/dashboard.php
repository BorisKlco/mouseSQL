    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Welcome, <?= htmlspecialchars(user('username')); ?>!</h1>
            <p class="text-gray-600">Here's your PostgreSQL database information</p>
        </div>

        <?php if ($pgDatabase): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Database Information Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Database Information</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Database Name</label>
                                <div class="mt-1 text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($pgDatabase['pg_database_name']); ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Database Host</label>
                                <div class="mt-1 text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($pgDatabase['pg_host']); ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Database Port</label>
                                <div class="mt-1 text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($pgDatabase['pg_port']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connection Details Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Connection Details</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Username</label>
                                <div class="mt-1 text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($pgDatabase['pg_username']); ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Password</label>
                                <div class="mt-1 text-lg font-medium text-gray-900">
                                    <span id="password-display">••••••••</span>
                                    <button
                                        id="toggle-password"
                                        class="ml-2 text-sm text-blue-600 hover:text-blue-800">
                                        Show
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Connection String</label>
                                <div class="mt-1 text-sm font-mono bg-gray-100 p-2 rounded">
                                    postgresql://<?php echo htmlspecialchars($pgDatabase['pg_username']); ?>:<span id="password-display-string">••••••••</span>@<?php echo htmlspecialchars($pgDatabase['pg_host']); ?>:<?php echo htmlspecialchars($pgDatabase['pg_port']); ?>/<?php echo htmlspecialchars($pgDatabase['pg_database_name']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden md:col-span-2">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Usage Statistics</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-center">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Database Size</label>
                                <p class="mt-1 text-2xl font-semibold text-gray-900"><?php echo htmlspecialchars($pgStats['size_pretty']); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Active Connections</label>
                                <p class="mt-1 text-2xl font-semibold text-gray-900"><?php echo htmlspecialchars($pgStats['connections']); ?></p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500">
                                Storage Quota (<?php echo htmlspecialchars($pgStats['size_pretty']); ?> of 50 MB)
                            </label>
                            <div class="mt-1 w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-blue-600 h-4 rounded-full" style="width: <?php echo min($usage, 100); ?>%"></div>
                            </div>
                            <p class="text-right text-sm text-gray-600 mt-1">
                                <?php echo $usage; ?>% used
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden md:col-span-2">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Actions</h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex flex-wrap gap-4">
                            <a href="/change_db_password" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Change Database Password
                            </a>
                            <a href="/db_info" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                View Detailed Database Info
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                <p><strong>Warning:</strong> No database information found for your account. Please contact support.</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('toggle-password');
            const passwordDisplay = document.getElementById('password-display');
            const passwordDisplayString = document.getElementById('password-display-string');
            let isPasswordVisible = false;

            <?php if ($pgDatabase): ?>
                const password = '<?php echo htmlspecialchars($pgDatabase['pg_password']); ?>';
            <?php endif; ?>

            togglePassword.addEventListener('click', function() {
                if (isPasswordVisible) {
                    passwordDisplay.textContent = '••••••••';
                    passwordDisplayString.textContent = '••••••••';
                    togglePassword.textContent = 'Show';
                } else {
                    passwordDisplay.textContent = password;
                    passwordDisplayString.textContent = password;
                    togglePassword.textContent = 'Hide';
                }
                isPasswordVisible = !isPasswordVisible;
            });
        });
    </script>