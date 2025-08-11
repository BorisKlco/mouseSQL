<div class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">User Management Panel</h1>
                <p class="text-gray-600 mt-1">Manage registered users and their PostgreSQL databases</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Login</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Database Size</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Options</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $user['last_login'] ? htmlspecialchars($user['last_login']) : 'Never' ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($user['created_at']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $user['db_size'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md text-sm font-medium transition-colors delete" data-user-id="<?= $user['id'] ?>">
                                            Delete
                                        </button>
                                        <?php if ($user['privileges_blocked']): ?>
                                            <button class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md text-sm font-medium transition-colors unblock-btn"
                                                data-user-id="<?= $user['id'] ?>">
                                                Unlock PostgreSQL
                                            </button>
                                        <?php else: ?>
                                            <button class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md text-sm font-medium transition-colors block-btn"
                                                data-user-id="<?= $user['id'] ?>">
                                                Block Inserts/Create
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.block-btn, .unblock-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const userId = this.dataset.userId;
            const action = this.classList.contains('block-btn') ? 'block' : 'unblock';
            const buttonText = this.textContent;

            this.textContent = 'Processing...';
            this.disabled = true;

            try {
                const response = await fetch('/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}&action=${action}`
                });

                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (result.error || 'Operation failed'));
                    this.textContent = buttonText;
                    this.disabled = false;
                }
            } catch (error) {
                alert('Network error: ' + error.message);
                this.textContent = buttonText;
                this.disabled = false;
            }
        });
    });

    let deleteButton = document.querySelectorAll('.delete');

    deleteButton.forEach(btn => {
        btn.addEventListener('click', async function() {
            const userId = this.dataset.userId;
            const action = 'delete';
            const buttonText = this.textContent;

            this.textContent = 'Processing...';
            this.disabled = true;

            try {
                const response = await fetch('/test', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}&action=${action}`
                });

                const result = await response.json();
                if (result.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (result.error || 'Operation failed'));
                    this.textContent = buttonText;
                    this.disabled = false;
                }
            } catch (error) {
                alert('Network error: ' + error.message);
                this.textContent = buttonText;
                this.disabled = false;
            }
        });
    });

</script>