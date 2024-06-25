<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeStock - Effortless Home Inventory Management</title>
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css'])

</head>
<body class="font-sans text-gray-800 bg-gray-100">
<header class="bg-blue-600 text-white">
    <nav class="container mx-auto px-6 py-3 flex justify-between items-center">
        <div class="text-xl font-bold">HomeStock</div>
        <div>
            <a href="/login" class="text-white hover:text-blue-200">Login</a>
        </div>
    </nav>
</header>

<main>
    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl font-bold mb-4">Take Control of Your Home Inventory</h1>
            <p class="text-xl mb-8">HomeStock simplifies home organization with an intuitive, self-hosted inventory system. Save time, reduce stress, and never lose track of your belongings again.</p>
            <img loading="lazy" style="height: 66vh" src="/welcome-hero.png" alt="HomeStock Dashboard" class="rounded-lg shadow-xl mb-8 mx-auto max-h-[66vh]" />
            <a href="/register" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-blue-100 transition duration-300">Start Organizing Today</a>
            <div class="mt-12 flex justify-center space-x-4">
                <div class="senja-embed mt-4 text-whie" data-id="98dd8322-b6c7-4fd1-a0e6-25337de59797" data-lazyload="false" ></div>

                <script async type="text/javascript" src="https://static.senja.io/dist/platform.js"></script>

            </div>
        </div>
    </section>

    <!-- Problem Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-8 text-center">Tired of Household Chaos?</h2>
            <p class="text-xl text-center max-w-3xl mx-auto">Disorganized homes lead to wasted time, unnecessary purchases, and increased stress. Without a proper inventory system, you risk losing valuable items and overspending on replacements.</p>
        </div>
    </section>

    <!-- Transformation Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-8 text-center">Imagine a Perfectly Organized Home</h2>
            <p class="text-xl text-center max-w-3xl mx-auto">With HomeStock, you'll enjoy a clutter-free environment, easy access to all your belongings, and significant time and money savings. Experience the peace of mind that comes with complete control over your home inventory.</p>
        </div>
    </section>

    <!-- Social Proof Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-12 text-center">What Our Users Say</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-gray-100 p-6 rounded-lg shadow">
                    <img src="./welcome-person.jpg" alt="Jane Doe" class="rounded-full mb-4 h-10 w-10"/>
                    <p class="mb-4">"HomeStock has transformed the way I manage my home. It's incredibly easy to use and has saved me countless hours!"</p>
                    <p class="font-bold">- Jane Doe, Homeowner</p>
                </div>
                <!-- Add more testimonials here -->
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-12 text-center">How HomeStock Works</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-4">1. Quick Setup</h3>
                    <p>Get started in minutes with our self-hosted solution. Your data stays private and secure.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-4">2. Easy Item Entry</h3>
                    <p>Add items effortlessly with custom fields, attachments, and auto-generated QR codes.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-bold mb-4">3. Smart Organization</h3>
                    <p>Use labels, locations, and our relation manager to create a system that works for you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-8 text-center">Why We Built HomeStock</h2>
            <p class="text-xl text-center max-w-3xl mx-auto mb-8">As homeowners ourselves, we understand the challenges of managing a household. We created HomeStock to solve our own organization problems and are excited to share it with you.</p>
            <p class="text-center text-gray-600">Featured on Product Hunt and Indie Hackers as a top emerging home management tool.</p>
        </div>
    </section>

    <!-- Updated Pricing Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-12 text-center">Choose Your Plan</h2>
            <div class="grid md:grid-cols-3 gap-8 ">
                <div class="bg-white p-8 rounded-lg shadow">
                    <h3 class="text-2xl font-bold mb-4">Free Self-Hosted</h3>
                    <p class="mb-6">Perfect for tech-savvy users</p>
                    <ul class="mb-6">
                        <li class="mb-2">✓ Unlimited items</li>
                        <li class="mb-2">✓ Basic features</li>
                        <li class="mb-2">✓ Community support</li>
                        <li class="mb-2">✓ Self-hosted on your server</li>
                    </ul>
                    <p class="text-2xl font-bold mb-6">$0/forever</p>
                    <a href="#" class="block text-center bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700 transition duration-300">Download</a>
                </div>
                {{--<div class="bg-white p-8 rounded-lg shadow">
                    <h3 class="text-2xl font-bold mb-4">Basic</h3>
                    <p class="mb-6">Great for small households</p>
                    <ul class="mb-6">
                        <li class="mb-2">✓ Up to 500 items</li>
                        <li class="mb-2">✓ Basic reporting</li>
                        <li class="mb-2">✓ Email support</li>
                        <li class="mb-2">✓ Cloud hosted</li>
                    </ul>
                    <p class="text-2xl font-bold mb-6">$9.99/month</p>
                    <a href="#" class="block text-center bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Choose Plan</a>
                </div>
                <div class="bg-white p-8 rounded-lg shadow">
                    <h3 class="text-2xl font-bold mb-4">Pro</h3>
                    <p class="mb-6">Ideal for large households</p>
                    <ul class="mb-6">
                        <li class="mb-2">✓ Unlimited items</li>
                        <li class="mb-2">✓ Advanced reporting</li>
                        <li class="mb-2">✓ Priority support</li>
                        <li class="mb-2">✓ Cloud hosted</li>
                    </ul>
                    <p class="text-2xl font-bold mb-6">$19.99/month</p>
                    <a href="#" class="block text-center bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Choose Plan</a>
                </div>--}}
            </div>
            <p class="text-center mt-8 text-gray-600">All paid plans come with a 30-day money-back guarantee. Choose between monthly or annual billing.</p>
        </div>
    </section>

    <!-- Updated FAQ Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-12 text-center">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto">
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Is HomeStock suitable for large households?</h3>
                    <p>Absolutely! Our scalable system can handle inventories of any size, from small apartments to large estates.</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">How secure is my data with HomeStock?</h3>
                    <p>We take data security seriously. For self-hosted plans, you have full control over your data security. For cloud-hosted plans, we use industry-standard encryption and security practices to protect your information.</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Can I access HomeStock from multiple devices?</h3>
                    <p>Yes, HomeStock is designed to be accessible from any device with an internet connection, including smartphones, tablets, and computers.</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">What's the difference between self-hosted and cloud-hosted options?</h3>
                    <p>Self-hosted means you install and run HomeStock on your own server, giving you full control but requiring technical know-how. Cloud-hosted means we manage the servers and infrastructure for you, providing an easier setup and automatic updates.</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Can I import my existing inventory data?</h3>
                    <p>Yes, HomeStock supports importing data from CSV files, making it easy to transfer your existing inventory information into the system.</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Is there a limit to how many items I can add?</h3>
                    <p>The free self-hosted plan and Pro plan have no item limits. The Basic plan allows up to 500 items, which is sufficient for most small households.</p>
                </div>
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-2">Do you offer customer support?</h3>
                    <p>Yes, we offer email support for all paid plans, with priority support for Pro users. Free self-hosted users can access community support through our forums and documentation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-20 bg-blue-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-8">Ready to Transform Your Home Organization?</h2>
            <a href="/register" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-blue-100 transition duration-300">Get Started with HomeStock</a>
        </div>
    </section>
</main>

<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; 2024 HomeStock. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
