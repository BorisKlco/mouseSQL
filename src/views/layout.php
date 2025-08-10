<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SERVICE_NAME . ' ' . $title . ' - PostgreSQL Service' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="<?= SERVICE_LOGO ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="flex justify-center items-center">
                    <img src="<?= SERVICE_LOGO ?>" alt="<?= SERVICE_NAME ?> Logo" class="size-24 mr-4 -mt-4 -mb-4">
                    <h1 class="text-3xl font-bold text-gray-800 mt-2"><?= SERVICE_NAME ?></h1>
                </a>
            </div>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="<?= getRoute('home') ?>" class="text-<?= currentRoute('home') ? 'blue-600 font-medium' : 'gray-600 hover:text-blue-600'; ?>">Home</a></li>
                    <?php if (logged()): ?>
                        <li><a href="<?= getRoute('dashboard') ?>" class="text-<?= currentRoute('dashboard') ? 'blue-600 font-medium' : 'gray-600 hover:text-blue-600'; ?>">Dashboard</a></li>
                        <li><a href="<?= getRoute('profile') ?>" class="text-<?= currentRoute('profile') ? 'blue-600 font-medium' : 'gray-600 hover:text-blue-600'; ?>">Profile</a></li>
                        <li>
                            <form action="<?= getRoute('logout') ?>" method="POST">
                                <?= csrf() ?>
                                <button type="submit" class="text-gray-600 hover:text-blue-600">
                                    Log out
                                </button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= getRoute('login') ?>" class="text-<?= currentRoute('login') ? 'blue-600 font-medium' : 'gray-600 hover:text-blue-600'; ?>">Login</a></li>
                        <li><a href="<?= getRoute('register') ?>" class="text-<?= currentRoute('register') ? 'blue-600 font-medium' : 'gray-600 hover:text-blue-600'; ?>">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        <?php include $slot; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <i class="fas fa-database text-blue-400 text-xl mr-2"></i>
                        <span class="text-lg font-semibold"><?= SERVICE_NAME ?></span>
                    </div>
                    <p class="mt-2 text-gray-400">Free PostgreSQL database instances for developers</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-discord"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-6 pt-6 text-center text-gray-400">
                <p>2025 - <?= SERVICE_NAME ?></p>
            </div>
        </div>
    </footer>
</body>

</html>