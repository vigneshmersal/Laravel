# Component

```js
Vue.component('my-component', {
	components: { // components that can be used in the template
		ProductComponent, ReviewComponent
	},
	props: { // accepted params
		message: String,
		product: Object,
		email: {
			type: String,
			required: true,
			default: "none"
			validator: function (value) {
				return true; // should return true if val is valid
			}
		}
	},
	data: function() { // must be a fun
		return {
			firstName: 'Vue',
			lastName: 'Mastery'
		}
	},
	computed: { // return cached val untill dependencies change
		fullName: function () {
			return this.firstName + ' ' + this.lastName
		}
	},
	watch: { // called when the field changes value
		firstName: function (value, oldValue) { ... }
	},
	methods: { ... },
	template: '<span>{{ message }}</span>', // use `backtick` for multiline
})

```
