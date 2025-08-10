<!-- Database Info Content -->
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Database Information</h1>
        <p class="text-gray-600">Detailed information about your PostgreSQL database</p>
    </div>

    <?php if ($pgDatabase): ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Connection Details -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Connection Information</h2>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-gray-600">Database Name:</span>
                            <span><?= htmlspecialchars($pgDatabase['pg_database_name']); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-gray-600">Username:</span>
                            <span><?= htmlspecialchars($pgDatabase['pg_username']); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-gray-600">Host:</span>
                            <span><?= htmlspecialchars($pgDatabase['pg_host']); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-gray-600">Port:</span>
                            <span><?= htmlspecialchars($pgDatabase['pg_port']); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-gray-600">Password:</span>
                            <span>
                                <span id="password-display"><?= htmlspecialchars($pgDatabase['pg_password']); ?></span>
                            </span>
                        </div>
                        <div class="pt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Connection String:</label>
                            <div class="bg-gray-50 p-3 rounded font-mono text-sm break-words">
                                postgresql://<?= htmlspecialchars($pgDatabase['pg_username']); ?>:<?= htmlspecialchars($pgDatabase['pg_password']); ?>@<?= htmlspecialchars($pgDatabase['pg_host']); ?>:<?= htmlspecialchars($pgDatabase['pg_port']); ?>/<?= htmlspecialchars($pgDatabase['pg_database_name']); ?>
                            </div>
                        </div>
                        <div class="pt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">JDBC URL:</label>
                            <div class="bg-gray-50 p-3 rounded font-mono text-sm break-words">
                                jdbc:postgresql://<?= htmlspecialchars($pgDatabase['pg_host']); ?>:<?= htmlspecialchars($pgDatabase['pg_port']); ?>/<?= htmlspecialchars($pgDatabase['pg_database_name']); ?>?user=<?= htmlspecialchars($pgDatabase['pg_username']); ?>&password=<?= htmlspecialchars($pgDatabase['pg_password']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Stats -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Database Statistics</h2>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                            <span class="font-medium text-gray-700">Database Size</span>
                            <span class="text-lg font-semibold"><?= $pgStats['size_pretty']; ?></span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-purple-50 rounded">
                            <span class="font-medium text-gray-700">Active Connections</span>
                            <span class="text-lg font-semibold"><?= $pgStats['connections']; ?></span>
                        </div>
                        <div class="pt-4">
                            <a href="/change_db_password" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block text-center">
                                Change Database Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Connection Examples -->
            <div class="lg:col-span-3 bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Connection Examples</h2>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-medium text-gray-700 mb-2">Python (psycopg2)</h3>
                            <pre class="bg-gray-800 text-green-400 p-4 rounded overflow-x-auto text-sm">
import psycopg2

conn = psycopg2.connect(
    host="<?= htmlspecialchars($pgDatabase['pg_host']); ?>",
    port=<?= htmlspecialchars($pgDatabase['pg_port']); ?>,
    database="<?= htmlspecialchars($pgDatabase['pg_database_name']); ?>",
    user="<?= htmlspecialchars($pgDatabase['pg_username']); ?>",
    password="<?= htmlspecialchars($pgDatabase['pg_password']); ?>"
)</pre>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 mb-2">Node.js (pg)</h3>
                            <pre class="bg-gray-800 text-green-400 p-4 rounded overflow-x-auto text-sm">
const { Client } = require('pg')

const client = new Client({
    host: '<?= htmlspecialchars($pgDatabase['pg_host']); ?>',
    port: <?= htmlspecialchars($pgDatabase['pg_port']); ?>,
    database: '<?= htmlspecialchars($pgDatabase['pg_database_name']); ?>',
    user: '<?= htmlspecialchars($pgDatabase['pg_username']); ?>',
    password: '<?= htmlspecialchars($pgDatabase['pg_password']); ?>',
})</pre>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700 mb-2">PHP (PDO)</h3>
                            <pre class="bg-gray-800 text-green-400 p-4 rounded overflow-x-auto text-sm">
$pdo = new PDO(
    'pgsql:host=<?= htmlspecialchars($pgDatabase['pg_host']); ?>;port=<?= htmlspecialchars($pgDatabase['pg_port']); ?>;dbname=<?= htmlspecialchars($pgDatabase['pg_database_name']); ?>',
    '<?= htmlspecialchars($pgDatabase['pg_username']); ?>',
    '<?= htmlspecialchars($pgDatabase['pg_password']); ?>'
);</pre>
                        </div>
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