<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-5">
    <h2 class="text-2xl font-semibold mb-6">Add New Task</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
        class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">

        <!-- Company -->
        <div>
            <label for="company" class="block text-gray-700 text-sm font-bold mb-2">Company:</label>
            <input type="text" id="company" name="company" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Info -->
        <div class="sm:col-span-2">
            <label for="info" class="block text-gray-700 text-sm font-bold mb-2">Info:</label>
            <textarea id="info" name="info" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
        </div>

        <!-- Amount -->
        <div>
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
            <input type="number" id="amount" name="amount" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Meeting Time -->
        <div>
            <label for="meeting_time" class="block text-gray-700 text-sm font-bold mb-2">Meeting Time:</label>
            <input type="datetime-local" id="meeting_time" name="meeting_time" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Platform -->
        <div>
            <label for="platform" class="block text-gray-700 text-sm font-bold mb-2">Platform:</label>
            <input type="text" id="platform" name="platform" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Meeting Link -->
        <div>
            <label for="meeting_link" class="block text-gray-700 text-sm font-bold mb-2">Meeting Link:</label>
            <input type="url" id="meeting_link" name="meeting_link" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Agenda Link -->
        <div class="">
            <label for="agenda_link" class="block text-gray-700 text-sm font-bold mb-2">Agenda Link:</label>
            <input type="url" id="agenda_link" name="agenda_link" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>

        <!-- Files Link -->
        <div class="">
            <label for="files_link" class="block text-gray-700 text-sm font-bold mb-2">Files Link:</label>
            <input type="url" id="files_link" name="files_link" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
        </div>


        <!-- Special Instructions -->
        <div class="sm:col-span-2">
            <label for="special_instructions" class="block text-gray-700 text-sm font-bold mb-2">Special
                Instructions:</label>
            <textarea id="special_instructions" name="special_instructions" required
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
        </div>

        <!-- Assigned To -->
        <div class="sm:col-span-2">
            <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Assign To:</label>
            <select id="assigned_to" name="assigned_to" required
                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6 sm:col-span-2">
            <input type="submit" value="Add Task"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        </div>
    </form>
</div>