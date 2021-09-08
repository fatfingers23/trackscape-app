<template>
    <form @submit.prevent="submit">
        <div>
            <jet-label for="email" value="Email"/>
            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus/>
        </div>

        <div class="mt-4">
            <jet-label for="password" value="Password"/>
            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                       autocomplete="current-password"/>
        </div>

        <div class="block mt-4">
            <label class="flex items-center">
                <jet-checkbox name="remember" v-model:checked="form.remember"/>
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <inertia-link v-if="canResetPassword" :href="route('password.request')"
                          class="underline text-sm text-gray-600 hover:text-gray-900">
                Forgot your password?
            </inertia-link>

            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
            </jet-button>
        </div>
    </form>
</template>

<script>
export default {
    name: "ConfirmationCode.vue"
}
</script>

<style scoped>

</style>
