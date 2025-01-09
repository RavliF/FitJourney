<!DOCTYPE html>
<html lang="en">

<?php include ('components/head.php') ?>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">

    <?php include ('components/navbar_login.php') ?>

        <div id="register" class="py-12">
            <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-6">Create Your Account</h2>

                <?php if(isset($error)): ?>
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="controller/regis.php?action=register" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Full Name</label>
                        <input type="text" name="name" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password" class="w-full p-2 border rounded" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                        Create Account
                    </button>
                </form>
                <p class="mt-4 text-center text-gray-600">
                    Already have an account? <a href="login.php" class="text-blue-600 hover:text-blue-800">Login here</a>
                </p>
            </div>
        </div>
    </div>

    <?php include ('components/footer.php') ?>

</body>
</html>
