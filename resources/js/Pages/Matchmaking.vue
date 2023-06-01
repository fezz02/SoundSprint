<script setup>
import { router } from '@inertiajs/vue3'

import { watch, computed, ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Display/Table/Table.vue'
import Row from '@/Components/Display/Table/Row.vue'

import { useVirtualList } from '@vueuse/core'


const props = defineProps({
  lobbies: {
    type: Array,
    required: true
  }
})

const itemHeight = 100;

const { list, containerProps, wrapperProps } = useVirtualList(
  Array.from(new Array(props.lobbies).keys()),
  {
    itemHeight
  },
)
</script>

<template>
    <AuthenticatedLayout/>
    <div class="relative grid m-2 place-content-center">
        <div class="grid gap-4 p-2 rounded-lg bg-neutral">
            <div class="grid grid-cols-1 gap-8 p-2 bg-base-200 sm:grid-cols-2 md:grid-cols-3">
                <div class="form-control">
                    <div class="input-group">
                      <input type="text" placeholder="Search…" class="input input-bordered" />
                      <button class="btn btn-square">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                      </button>
                    </div>
                </div>
                <button class="btn btn-primary text-primary-content">Join random</button>
                <button class="btn btn-success text-success-content">Create lobby</button>
                <div class="form-control">
                    <label class="cursor-pointer label">
                      <span class="label-text">Friends only</span> 
                    </label>
                    <input type="checkbox" class="checkbox checkbox-primary" />
                </div>
            </div>
            <div class="bg-base-100 text-base-content">
              <div class="grid grid-flow-col gap-4 p-6 auto-cols-fr justify-items-center place-items-center bg-base-300 text-neutral-content">
                <div>Code</div>
                <div>Players</div>
                <div>Status</div>
                <div>Action</div>
              </div>
                <div v-bind="containerProps" style="height: 300px">
                  <div v-bind="wrapperProps" class="divide-y divide-blue-200">
                    <div v-for="item in props.lobbies.data" :key="item.index" :style="'height: ' + itemHeight + 'px'" class="grid grid-flow-col gap-4 p-2 auto-cols-fr justify-items-center place-items-center">

                      <div>{{ item.code }}</div>
                      <div>{{ item.current_players + ' / ' + item.max_players }}</div>
                      <div>{{ item.status }}</div>
                      <div><button class="btn btn-outline btn-success">Join</button></div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        
    </div>
</template>