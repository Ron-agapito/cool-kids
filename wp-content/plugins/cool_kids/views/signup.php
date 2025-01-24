<div <?php # phpcs:ignore?>
	class="flex flex-col justify-center px-6 py-12 lg:px-8">
	<div class="sm:mx-auto sm:w-full sm:max-w-sm">
		<h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
			<?php echo esc_html( __( 'Register a new account', 'cool-kids' ) ); ?>
		</h2>
	</div>

	<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
		<form @submit.prevent="signup.submit"
				class="space-y-6" action="#" method="POST">
			<div>
				<label for="email" class="block text-sm/6 font-medium text-gray-900">
					<?php echo esc_html( __( 'Email address', 'cool-kids' ) ); ?>
				</label>
				<div class="mt-2">
					<input x-model="signup.email" type="email" name="email" id="coolkid-signup-email"
							autocomplete="email" required
							class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
				</div>
			</div>

			<div>
				<button x-bind:disabled="signup.isSubmitting"
						type="submit"
						class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
					<?php echo esc_html( __( 'Register', 'cool-kids' ) ); ?>
				</button>
			</div>
		</form>

		<div x-show="signup.successMessage"
			class="text-sm/6 mt-4  border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
			<span class="block sm:inline" x-text="signup.successMessage"></span>
		</div>

		<div x-show="signup.errorMessage"
			class="text-sm/6 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
			role="alert">
			<strong class="font-bold">Error!</strong>
			<span class="block sm:inline" x-text="errorMessage"></span>
		</div>


	</div>
</div>

