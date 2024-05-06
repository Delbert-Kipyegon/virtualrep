<div class="mt-4">
    <h2 class="text-xl font-semibold mb-4">Notifications</h2>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <?php if (!empty($notificationsByDate)): ?>
            <?php foreach ($notificationsByDate as $date => $notifications): ?>
                <h3 class="px-4 py-4 bg-gray-100 text-gray-700 text-sm font-semibold">
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
            <div class="text-center py-4">No Notifications</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>