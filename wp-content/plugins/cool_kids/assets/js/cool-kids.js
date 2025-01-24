document.addEventListener('alpine:init', () => {
	Alpine.store('CoolKids', {
		isLoaded: false,
		errorMessage: '',
		isLoggedIn: false,
		page:'main',
		login: {
			show:false,
			email: '',
			errorMessage: '',
			submitForm() {

				wp.apiFetch({
					path: '/cool-kids/v1/login',
					method: 'POST',
					data: {
						email: this.login.email,
					},
				})
					.then((data) => {
						if (!data.success) {
							this.errorMessage = data.message;
							return;
						}
						this.isLoggedIn = true;
						 location.reload();
					})
					.catch((error) => {
						console.error('Error:', error);
						this.errorMessage = error.message;
					});
			},
		},

		myAccount: {
			email: '',
			first_name: '',
			last_name: '',
			initials: '',
			role: '',
			country: '',
			errorMessage: '',
			getAccount() {
				wp.apiFetch({path: 'cool-kids/v1/my-account'})
					.then((data) => {

						this.email = data.email;
						this.first_name = data.first_name;
						this.last_name = data.last_name;
						this.initials = data.initials;
						this.role = data.role;
						this.country = data.country;
					})
					.catch((error) => {
						this.errorMessage = error.message;
					});
			},
		},

		users: {
			list: [],
			pager: {
				page: 1,
				showLoadMore: false,
			},

			get() {
				wp.apiFetch({path: 'cool-kids/v1/list?page=' + this.pager.page})
					.then((data) => {
						if (data.error) {
							this.errorMessage = data.message;
							return;
						}
						this.pager.showLoadMore = data.length > 0;
						this.list = [...this.list, ...data];
					})
					.catch((error) => {
						this.errorMessage = error.message;
					});
			},
		},



		signup:{

			email: '',
			errorMessage:'',
			successMessage:'',
			isSubmitting: false,
			submit(){
                   				this.isSubmitting = true;
				wp.apiFetch( {
					path:'/cool-kids/v1/signup',
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-WP-Nonce': this.nonce, // Make sure nonce is set correctly
					},
					data: {
						email: this.signup.email,
					},
				})
					.then((data) => {
						if (data.success) {
							this.signup.successMessage = data.message;
							this.signup.errorMessage = '';
						}

						this.isSubmitting = false;
					})
					.catch((error) => {
						this.signup.errorMessage = error.message;
						this.signup.successMessage = '';
						this.signup.isSubmitting = false;

					});

			}
		},

	});

});

wp.domReady(() => {
	Alpine.store('CoolKids').isLoaded = true;
});
