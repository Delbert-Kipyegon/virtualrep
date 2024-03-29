<div class="mt-8">
    <h2 class="text-xl font-semibold mb-4">Notifications</h2>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <!-- PHP loop through notifications -->
            <?php foreach ($notifications as $notification): ?>
                <li class="px-4 py-4 flex items-center sm:px-6">
                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <div class="text-sm leading-5 font-medium text-blue-600 truncate">
                                <?php echo $notification['message']; ?>
                            </div>
                            <div class="mt-2 flex">
                                <div class="flex items-center text-sm leading-5 text-gray-500">
                                    <!-- Additional details can go here -->
                                    <?php echo $notification['date']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>