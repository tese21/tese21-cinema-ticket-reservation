<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <?php include ('header.php');?>

    <!-- Developers Section -->
    <section id="developers" class="container mx-auto py-10 px-3">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">Our Developers</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Developer 1 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="img/admin.jpg" alt="Tesema" class="w-full h-60 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Tesema</h3>
                <p class="text-gray-700"><strong>Phone:</strong> +251 935433756</p>
                <p class="text-gray-700"><strong>Department:</strong> Computer scinece</p>
            </div>
            <!-- Developer 2 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="../uploads/belete.jpg" alt="Belete" class="w-full h-60 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Temesgen</h3>
                <p class="text-gray-700"><strong>Phone:</strong> +251 912345679</p>
                <p class="text-gray-700"><strong>Department:</strong> Computer scinece</p>
            </div>
            <!-- Developer 3 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="../uploads/temesgen.jpg" alt="Temesgen" class="w-full h-60 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Belete</h3>
                <p class="text-gray-700"><strong>Phone:</strong> +251 912345680</p>
                <p class="text-gray-700"><strong>Department:</strong> Computer scinece</p>
            </div>
            <!-- Developer 4 -->
            <div class="bg-white p-4 rounded-lg shadow-md">
                <img src="../uploads/ahlam.jpg" alt="Ahlam" class="w-full h-60 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">Ahlam</h3>
                <p class="text-gray-700"><strong>Phone:</strong> +251 912345681</p>
                <p class="text-gray-700"><strong>Department:</strong> Computer scinece</p>

            </div>
        </div>
    </section>
    <?php include ('footer.php');?>
</body>
</html>