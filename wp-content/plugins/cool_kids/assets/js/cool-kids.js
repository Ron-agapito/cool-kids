function coolKidLoginForm(nonce) {
	return {
		email: '',
		isLoggedIn: false,  // Initially, the user is not logged in
		errorMessage: '',

		submitForm() {
			fetch('/wp-json/cool-kids/v1/login', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					//	'X-WP-Nonce': nonce,
				},
				body: JSON.stringify({
					email: this.email
				})
			})
				.then(response => response.json())
				.then(data => {
						if (!data.success) {
							this.errorMessage = data.message;
							return;
						}


						document.cookie = data.cookie
						this.isLoggedIn = true;  // Update the login state

						//reload
						location.reload();
						//	setTimeout(() => {
						//this.$dispatch('login', {isLoggedIn: true, nonce: data?.nonce});
						//}, 100);  // Delay of 1 second

						// Dispatch an event to notify `coolKidMyAccount` component to refresh the data
					}
				)
				.catch(error => {
					console.error('Error:', error);
				});
		}
	}
}

function coolKidMyAccount() {
	return {
		first_name: '',
		last_name: '',
		email: '',
		country: '',
		role: '',
		initials: '',
		errorMessage: '',
		isLoggedIn: false,
		nonce: "",
		fetchMyAccount() {
			if (!this.isLoggedIn) {
				return;
			}
			fetch('/wp-json/cool-kids/v1/my-account', {
				method: 'GET',
				credentials: 'include', // Ensures cookies are sent

				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': this.nonce,
				}
			})
				.then(response => response.json())
				.then(data => {
					if (data.error) {
						this.errorMessage = data.message;
						return;
					}
					this.email = data.email;
					this.first_name = data.first_name;
					this.last_name = data.last_name;
					this.country = data.country;
					this.role = data.role;
					this.initials = data.initials;
				})
				.catch(error => {
					console.error('Error:', error);
					this.errorMessage = 'An error occurred while fetching account data';
				});
		}
	}
}

function coolKidList() {
	return {
		coolKids: [],
		errorMessage: '',
		nonce: '',
		page: 1,
		showLoadMore: false,
		fetchList() {
			fetch(`/wp-json/cool-kids/v1/list?page=${this.page}`, {
				method: 'GET',
				credentials: 'include', // Ensures cookies are sent
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': this.nonce,
				}
			})
				.then(response => response.json())
				.then(data => {
					if (data.error) {
						this.errorMessage = data.message;
						return;
					}

					this.showLoadMore = data.length > 0;

					this.coolKids = [...this.coolKids, ...data];

				})
				.catch(error => {
					console.error('Error:', error);
					this.errorMessage = 'An error occurred while fetching cool kids';
				});
		}
	}
}

