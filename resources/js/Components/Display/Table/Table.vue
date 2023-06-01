<script setup>
const props = defineProps({
    action: {
        type: Boolean,
        default: false
    },
    before: {
        type: Boolean,
        default: false
    },
    columns: {
        type: Array,
        required: true
    },
    data: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <table class="table w-full">
        <thead>
            <tr>
                <template v-for="colItem in props.columns" :key="colItem.field">
                    <td v-if="props.action && props.before">
                        <slot :col-item="colItem"/>
                    </td>
                    
                    <td>
                        <template v-if="colItem?.merge">
                            <template v-for="mergeCol in colItem?.merge?.columns" :key="mergeCol?.field">
                                {{ mergeCol?.label + colItem?.merge?.separator}}
                            </template>
                        </template>
                        <template v-else>
                            {{ colItem.label }}
                        </template>
                    </td>

                    <td v-if="props.action && !props.before">
                        <slot :col-item="colItem"/>
                    </td>
                </template>
            </tr>
        </thead>
        <tbody>
            <tr v-for="rowItem in props.data" :key="rowItem.id">
                <td v-if="props.action && props.before">
                    <slot :row-item="rowItem"/>
                </td>
                
                <td v-for="colItem in props.columns" :key="colItem.field">
                    <template v-if="colItem?.merge">
                        <template v-for="mergeCol in colItem?.merge?.columns" :key="mergeCol?.field">
                            {{ rowItem[mergeCol?.field] + colItem?.merge?.separator }}
                        </template>
                    </template>
                    <template v-else>
                        {{ rowItem[colItem.field] }}
                    </template>
                </td>
                
                <td v-if="props.action && !props.before">
                    <slot :row-item="rowItem"/>
                </td>
            </tr>
            <slot name="body"/>
        </tbody>
    </table>
</template>