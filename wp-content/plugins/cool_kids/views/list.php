<div
	x-data="coolKidList()"
	x-show="coolKids.length"
	x-init="isLoggedIn=<?php echo is_user_logged_in(); ?>; nonce='<?php echo $nonce; ?>'; fetchList()"
	class="bg-white shadow-sm rounded-lg p-4  max-h-96 overflow-y-auto">
	<ul role="list" class="divide-y divide-gray-100">
		<template x-for="(kid, index) in coolKids" :key="index">

			<li class="flex justify-between gap-x-6 py-5">
				<div class="flex min-w-0 gap-x-4">
					<img class="size-12 flex-none rounded-full bg-gray-50"
						 x-bind:src="'https://placehold.co/100x100?text='+kid.initials"
						 loading="lazy">
					<div class="min-w-0 flex-auto">
						<p x-text="kid.first_name + ' ' + kid.last_name"
						   class="text-sm/6 font-semibold text-gray-900"></p>
						<p x-text="kid.email" class="mt-1 truncate text-xs/5 text-gray-500"></p>
					</div>
				</div>
				<div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
					<p x-text="kid.role" class="text-sm/6 text-gray-900"></p>
					<p x-text="kid.country" class="mt-1 text-xs/5 text-gray-500">Last seen
					</p>
				</div>
			</li>
		</template>

	</ul>

	<div x-show="showLoadMore" class="flex justify-center mt-4">
		<button @click="page++; fetchList()" class="border-0 text-sm/6 font-semibold text-primary-600 hover:underline">
			Load
			more
		</button>
	</div>

</div>
