<script setup>
import NavProfile from '@/Components/Nav/NavProfile.vue';
import NavHamburger from '@/Components/Nav/NavHamburger.vue';
import NavLink from '@/Components/Nav/NavLink.vue';

const routes = [
    {
        label: 'Play',
        name: 'play.index',
    },
    {
        label: 'mmk',
        name: 'mmk.index'
    }
]

</script>

<template>
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <NavHamburger/>
          <a class="text-xl normal-case btn btn-ghost">daisyUI</a>
        </div>
        <div class="hidden navbar-center lg:flex">
            <ul class="px-1 menu menu-horizontal">
              <NavLink
                v-for="route in routes"
                :name="route.name"
                :label="route.label"
              />
              
            </ul>
          </div>

        <div class="navbar-end">
            <NavProfile
            />
        </div>
      </div>
    <slot/>
</template>
