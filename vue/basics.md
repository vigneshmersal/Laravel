# Vue

https://github.com/sdras/intro-to-vue

## Install
### Vue chrome devtools
    - https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd?hl=en
### Vue 3
    - https://chrome.google.com/webstore/detail/vuejs-devtools/ljjemllljcmogpfapbkkighbhhppjdbg
### codepen debugger
    - https://chrome.google.com/webstore/detail/codopen/agnkphdgffianchpipdbkeaclfbobaak
### Vetur
    https://marketplace.visualstudio.com/items?itemName=octref.vetur
### Vue VSCode Snippets
    https://marketplace.visualstudio.com/items?itemName=sdras.vue-vscode-snippets
### Vue VS Code Extension Pack
    - https://marketplace.visualstudio.com/items?itemName=sdras.vue-vscode-extensionpack
### Vue Online Editor
    - https://codepen.io/pen/editor/vue

---

## HTML
```php
<div id="app"></div

# Expressions
{{ product + 's' }} - Append
{{ isWorking ? 'YES' : 'NO' }} - Condition
{{ product.getSalePrice() }} - fun

# DIRECTIVES
<p v-if="inStock"></p>
<p v-else-if="inStock"></p>
<p v-else="inStock"></p>

# Toggle display
<p v-show="showProductDetails"></p>

# Two way data bindings
<input v-model="firstName">
v-model.lazy="..." Syncs input after change event
v-model.number="..." Always returns a number
v-model.trim="..." Strips whitespace

# Binding (v-bind:href)
<a :href="url">...</a>
<button :disabled="isButtonDisabled"> // true/false will add/remove attribute
<div :class="{ active: isActive }"> // true/false will add/remove class ‘active’
<div :style="{ color: activeColor }"> // color val from variable:activeColor

# LIST RENDERING
<li v-for="item in items" :key="item.id"> // key always recommended
<li v-for="(item, index) in arrayItems"> // array with index/item pair
<li v-for="(value, key) in objectItems"> // object with key/val pair

## ACTIONS / EVENTS (v-on:click)
<button @click="addToCart"> // call method
<button @click="addToCart(arg)"> // pass arguments
<form @submit.prevent="addProduct"> // prevent
<img @mouseover.once="showImage"> // only trigger once
<input @keyup.enter="submit"> // keyboard hit enter key
<input @keyup.ctrl.c="onCopy"> // keyboard hit ctrl+c key

.stop - Stop all event propagation
.self - Only trigger if event.target is element itself
.tab
.delete
.esc
.space
.up
.down
.left
.right
.ctrl
.alt
.shift
.meta
.middle
```

## balde file
```php
<example-component></example-component>
```

## app.js
```js
Vue.component( 'example-component', require('./components/ExampleComponent.vue').default );
```

## Run
watch continues changes: `npm run watch`
compile: `npm run dev`

```js
Vue.createApp(App).mount("#app");
```

# computed 
Usage: filter based on user input