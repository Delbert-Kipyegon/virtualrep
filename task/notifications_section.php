<div class="bg-white shadow  h-screen rounded-md overflow-y-auto flex flex-col">
    <div class="mt-4 p-4">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>
        <?php if (!empty($notificationsByDate)): ?>
            <?php foreach ($notificationsByDate as $date => $notifications): ?>
                <h3 class="px-4 py-4 bg-gray-100 text-gray-700 text-sm font-semibold rounded-md">
                    <?php echo htmlspecialchars($date); ?>
                </h3>
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($notifications as $notification): ?>
                        <li class="px-4 py-4 flex flex-col sm:flex-row items-start sm:items-center sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="text-sm leading-5 font-medium text-blue-600 truncate">
                                    Task Name:
                                    <?php echo htmlspecialchars($notification['task_name']); ?> -
                                    <?php echo htmlspecialchars($notification['status']); ?>
                                </div>
                                <div class="text-sm leading-5 text-gray-500">
                                    <?php echo htmlspecialchars($notification['comments']); ?>
                                </div>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <div class="text-sm leading-5 text-gray-500">
                                    User:
                                    <?php echo htmlspecialchars($notification['user_email']); ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-4">
                <!-- SVG for no notifications -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto mb-4" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 2a8 8 0 00-8 8c0 3.38 2.464 6.197 5.678 6.788.233.885.928 1.571 1.769 1.791C8.443 19.094 9.213 20 10 20s1.557-.906 2.553-1.421c.841-.22 1.536-.906 1.769-1.791C17.536 16.197 20 13.38 20 10a8 8 0 00-8-8zM8 11a1 1 0 11-2 0 1 1 0 012 0zm2 0a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0z"
                        clip-rule="evenodd" />
                </svg>
                <p>No Notifications</p>
            </div>
        <?php endif; ?>
    </div>
</div>