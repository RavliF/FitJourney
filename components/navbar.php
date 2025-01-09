<nav class="bg-white border-b">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="index.php" class="flex items-center space-x-3">
            <span class="self-center text-2xl font-semibold">FitJourney</span>
        </a>
        <button type="button" class="md:hidden" data-collapse-toggle="navbar-menu">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-menu">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-8 md:mt-0">
                <li><a href="calculate_bmi.php" class="block py-2 px-3">BMI Calculator</a></li>
                <li><a href="log_exercise.php" class="block py-2 px-3">Exercise Log</a></li>
                <li><a href="logout.php" class="block py-2 px-3">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>