<section   x-data="$store.CoolKids" <?php # phpcs:ignore?>
           x-init="isLoggedIn=<?php echo is_user_logged_in() ? 'true' : 'false'; ?>;"
			class="bg-gray-100 ">
	<div class="container px-4 mx-auto py-8">



		<div class="text-center max-w-2xl m-auto">
			<h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">
				<?php echo esc_html( $title ); ?>
			</h1>
			<p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">
				<?php echo esc_html( $description ); ?>
			</p>
			<div x-show="!isLoggedIn" class="mt-10 flex items-center justify-center gap-x-6">
				<button  @click="page='login'" href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
					<?php echo esc_html( __( 'Login', 'cool-kids' ) ); ?>
				</button>
				<a  @click.prevent="page='signup'" href="#" class="text-sm/6 font-semibold text-gray-900">
					<?php echo esc_html( __( 'Register', 'cool-kids' ) ); ?>
					<span aria-hidden="true">→</span></a>
			</div>

			<div x-show="isLoggedIn" class="mt-10  flex items-center justify-center gap-x-6">

				<a   href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" class="text-sm/6 font-semibold text-gray-900">
					<?php echo esc_html( __( 'Logout', 'cool-kids' ) ); ?>
					<span aria-hidden="true">→</span></a>
			</div>
		</div>


		<template  x-if="isLoaded && page=='login'">
			<?php
			require plugin_dir_path( __FILE__ ) . '/login.php';
			?>
		</template>


		<template  x-if="isLoaded && page=='signup'">
			<?php
			require plugin_dir_path( __FILE__ ) . '/signup.php';
			?>
		</template>

		<template  x-if="isLoaded && isLoggedIn">
			<?php
			require plugin_dir_path( __FILE__ ) . '/my-account.php';
			?>
		</template>





	</div>


</section>


