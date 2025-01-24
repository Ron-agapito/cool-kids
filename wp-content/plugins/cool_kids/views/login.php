<div <?php # phpcs:ignore?>
	 x-show="!isLoggedIn && page=='login'"
	class="flex flex-col justify-center px-6 py-12 lg:px-8">
	<div class="sm:mx-auto sm:w-full sm:max-w-sm">
<h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900"><?php echo esc_html( __( 'Sign in to your account', 'cool-kids' ) ); ?></h2>
	<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
		<form  @submit.prevent="login.submitForm"
			class="space-y-6" action="#" method="POST">
			<div>
				<label for="email" class="block text-sm/6 font-medium text-gray-900"><?php echo esc_html( __( 'Email Address', 'cool-kids' ) ); ?></label>
				<div class="mt-2">
					<input x-model="login.email"  type="email" name="email" id="coolkid-email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
				</div>
			</div>


			<div>
				<button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
					<?php echo esc_html( __( 'Sign in', 'cool-kids' ) ); ?>
				</button>
			</div>

			<p  x-show="login.errorMessage" class="mt-4 text-center text-sm/6 text-red-500">
				<span class="block sm:inline" x-text="login.errorMessage"></span>
			</p>

		</form>


	</div>
</div>



