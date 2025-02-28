<?php
// header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Movie Ticket System</title>
  <!-- Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="icon" href="images/logo.ico" type="image/x-icon" />
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* General Styles */
    body {
      background-color: #f8f9fa;
      color: #343a40;
    }
    .navbar {
      background-color: rgba(31, 41, 55, 0.8);
    }
    .navbar.scrolled {
      background-color: rgba(31, 41, 55, 1);
    }
    .dropdown-content {
      display: none;
    }
    .dropdown-content.show {
      display: block;
    }
  </style>
</head>
<body class="bg-white text-gray-900">
  <!-- Header Section with changed background color -->
  <header class="bg-blue-600 p-4 shadow-md flex justify-between items-center">
    <!-- Logo -->
    <div class="logo-container">
      <img src="../img/log.png" alt="Logo" class="h-12" />
    </div>
    <!-- Search Bar and Profile Icon -->
    <div class="flex items-center space-x-4">
      <!-- Search Bar -->
      <form action="customer/search_movie.php" method="GET" class="relative">
        <input type="text" id="searchInput" name="title" placeholder="Search movies..." class="p-2 pl-10 rounded bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400">
        <span class="absolute left-3 top-2 text-gray-400">
        </svg>
      </span>
    </form>
  </header>
  <!-- Navigation Menu -->
  <nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 shadow-lg transition duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <ul class="flex space-x-4">
        <li><a href="customer_dashboard.php" class="text-white hover:text-yellow-400 transition duration-300">Home</a></li>
        <li><a class="text-white hover:text-yellow-400" href="#movies">Movies</a></li>
        <li><a class="text-white hover:text-yellow-400" href="about_us.php">About Us</a></li>
        <li><a class="text-white hover:text-yellow-400" href="schedule.php">Schedule</a></li>
        <li><a class="text-white hover:text-yellow-400" href="../help.php">Help</a></li>    
        <li><a class="text-white hover:text-yellow-400" href="contact_us.php">Contact</a></li>
        <li><a class="text-white hover:text-yellow-400" href="feedback.php">feedback</a></li>
      </ul>
      
      <div class="relative inline-block text-left">
        <div>
          <button onclick="toggleDropdown()" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
            <i class="fas fa-user-circle text-2xl"></i>
          </button>
        </div>
        <div id="dropdownMenu" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
          <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <a href="myprofile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">My Profile</a>
            <a href="seting.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
            <a href="ticket_history.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Ticket History</a>
            <a href="../logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <script>
    function toggleDropdown() {
      var dropdownMenu = document.getElementById("dropdownMenu");
      dropdownMenu.classList.toggle("hidden");
      console.log("Dropdown toggled"); // Debugging statement
    }

    window.onclick = function(event) {
      if (!event.target.matches('.fas.fa-user-circle')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (!openDropdown.classList.contains('hidden')) {
            openDropdown.classList.add('hidden');
          }
        }
      }
    }

    // Change navbar background color on scroll
    window.addEventListener('scroll', function() {
      var navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
</body>
</html>
