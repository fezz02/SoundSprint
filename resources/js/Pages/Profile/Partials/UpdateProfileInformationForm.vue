<script setup>
import InputError from '@/Components/InputError.vue';
import Label from '@/Components/Input/Label.vue';
import Input from '@/Components/Input/Input.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-info">
                {{ $t('profile.info.title') }}
            </h2>

            <p class="mt-1 text-sm text-base-content">
                {{ $t('profile.info.description') }}
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6 ">
            <div>
                <Label for="name" :value="$t('profile.info.form.name.label')" />

                <Input
                    id="name"
                    type="text"
                    required
                    class="input-bordered input-info w-full"
                    autocomplete="name"
                    :placeholder="$t('profile.info.form.name.placeholder')"

                    v-model="form.name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <Label for="email" :value="$t('profile.info.form.email.label')" />

                <Input
                    id="email"
                    type="email"
                    required
                    class="input-bordered input-info"
                    autocomplete="username"
                    :placeholder="$t('profile.info.form.email.placeholder')"

                    v-model="form.email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-base-content">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="btn btn-outline btn-info" :disabled="form.processing">
                    {{ $t('profile.pwd.form.save') }}
                </button>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
