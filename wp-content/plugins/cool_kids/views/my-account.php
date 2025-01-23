<section
	class="bg-gray-100 ">
	<div class="container mx-auto py-8">

		<?php
		include plugin_dir_path( __FILE__ ) . '/login.php';
		?>

		<div class="lg:grid grid-cols-3 lg:gap-4">

			<div
				x-data="coolKidMyAccount()"
				x-init="isLoggedIn = <?php echo is_user_logged_in(); ?>; nonce = '<?php echo $nonce; ?>'; fetchMyAccount()"

				x-show="isLoggedIn"

				class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow-sm">
				<div class="flex flex-1 flex-col p-8">
					<img class="mx-auto size-32 shrink-0 rounded-full"
						 x-bind:src="'https://placehold.co/100x100?text='+initials"
						 loading="lazy">
					<h3 x-text="first_name + ' ' + last_name" class="mt-6 text-sm font-medium text-gray-900"></h3>
					<dl class="mt-1 flex grow flex-col justify-between">
						<dt class="sr-only">Country</dt>
						<dd x-text="country" class="text-sm text-gray-500"></dd>

						<dt class="sr-only">Role</dt>
						<dd class="mt-3">
							<span
								x-text="role"
								class="inline-flex items-center rounded-full bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 ring-1 ring-gray-600/20 ring-inset"></span>
						</dd>
					</dl>
				</div>
				<div>
					<div class="-mt-px flex divide-x divide-gray-200">
						<div class="flex w-0 flex-1">
							<a x-bind:href="'mailto:' + email"
							   class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
								<svg class="size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
									 aria-hidden="true" data-slot="icon">
									<path
										d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z"></path>
									<path
										d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z"></path>
								</svg>
								Email : <span x-text="email"></span>
							</a>
						</div>

					</div>
				</div>
			</div>


			<div class="col-span-2">
				<?php
				include plugin_dir_path( __FILE__ ) . '/list.php';
				?>

			</div>
		</div>


	</div>


</section>

