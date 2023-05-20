<script setup>
import ErrorText from '@/Components/Error/ErrorText.vue';
import Label from '@/Components/Input/Label.vue';
import Input from '@/Components/Input/Input.vue';
import Button from '@/Components/Input/Button.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    console.log(form.current_password);
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-warning">
                {{ $t('profile.pwd.title') }}
            </h2>

            <p class="mt-1 text-sm text-base-content">
                {{ $t('profile.pwd.description') }}
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6 ">
            <div>
                <Label for="current_password" :value="$t('profile.pwd.form.current.label')" />

                <Input
                    id="current_password"
                    ref="currentPasswordInput"
                    type="password"
                    class="input-bordered input-warning"
                    autocomplete="current-password"
                    :placeholder="$t('profile.pwd.form.current.placeholder')"

                    v-model.lazy="form.current_password"
                />

                <ErrorText :message="form.errors.current_password" class="mt-2" />
            </div>

            <div>
                <Label for="password" :value="$t('profile.pwd.form.new.label')" />

                <Input
                    id="password"
                    ref="passwordInput"
                    type="password"
                    class="input-bordered input-warning"
                    autocomplete="new-password"
                    :placeholder="$t('profile.pwd.form.new.placeholder')"

                    v-model="form.password"
                />

                <ErrorText :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <Label for="password_confirmation" :value="$t('profile.pwd.form.confirm.label')" />

                <Input
                    id="password_confirmation"
                    type="password"
                    class="input-bordered input-warning"
                    autocomplete="new-password"
                    :placeholder="$t('profile.pwd.form.confirm.placeholder')"

                    v-model="form.password_confirmation"
                />

                <ErrorText :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <Button class="btn-outline btn-warning" :disabled="form.processing">
                    {{ $t('profile.pwd.form.save') }}
                </Button>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
