<div class="mt-8">
    <h2 class="text-xl font-semibold mb-4">All Users</h2>
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    First Name
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Last Name
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Email
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- PHP code to loop through users and display -->
            <?php foreach ($users as $user): ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php echo $user['fname']; ?>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php echo $user['lname']; ?>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php echo $user['email']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>