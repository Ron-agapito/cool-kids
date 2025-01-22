<section class="bg-gray-50 dark:bg-gray-900" x-data="coolKidLoginForm('<?php echo ($nonce); ?>')">
	<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

		<div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
					Login
				</h1>
				<form class="space-y-4 md:space-y-6" @submit.prevent="submitForm">
					<div>
						<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
						<input x-model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
					</div>


					<div x-show="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
						<strong class="font-bold">Error!</strong>
						<span class="block sm:inline" x-text="errorMessage"></span>
						<span class="absolute top-0 bottom-0 right-0 px-4 py-3">
							<svg @click="errorMessage = ''" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								<title>Close</title>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M14.95 5.05a.75.75 0 0 1 1.06 1.06L11.06 10l4.95 4.95a.75.75 0 1 1-1.06 1.06L10 11.06l-4.95 4.95a.75.75 0 0 1-1.06-1.06L8.94 10 4.05 5.05a.75.75 0 0 1 1.06-1.06L10 8.94l4.95-4.95z"></path>
							</svg>
						</span>
					</div>





					<button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login</button>

				</form>
			</div>
		</div>
	</div>
</section>


<div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700" x-data="coolKidMyAccount('<?php echo ($nonce); ?>')" x-init="fetchMyAccount()">

	<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>

	<p class="font-normal text-gray-700 dark:text-gray-400" x-text="email">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
</div>

<script>

	function coolKidMyAccount(nonce) {
    return {
		first_name: '',
		last_name:'',
        email: '',
		country: '',
        message: '',
        errorMessage: '',
        fetchMyAccount() {
            fetch('/wp-json/cool-kids/v1/my-account', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': nonce,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    this.errorMessage = data.message;
                    return;
                }
                this.email = data.email;
                this.message = 'Account data retrieved successfully';
            })
            .catch(error => {
                console.error('Error:', error);
                this.errorMessage = 'An error occurred while fetching account data';
            });
        }
    }
}
	function coolKidLoginForm(nonce) {
		return {
			email: '',
			message: '',
			errorMessage: '',
			submitForm() {
				fetch('/wp-json/cool-kids/v1/login', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-WP-Nonce': nonce,
					},
					body: JSON.stringify({
						email: this.email

					})
				})
					.then(response => response.json())
					.then(data => {


						if(!data.success){
							this.errorMessage= data.message;
							return;
						}
						this.message = data.message;


					})
					.catch(error => {
						console.error('Error:', error);

					});
			}
		}
	}
</script>
