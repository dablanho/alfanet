<template>
    <div
        role="alert"
        v-bind:class="{ show: datas }"
        class="alert fade alert-danger"
    >
        <div class="alert-text" v-for="(error, i) in datas" :key="i">
            <span style="text-transform: capitalize">{{ error.join("") }}</span>
        </div>
    </div>
    <!--<ul id="v-for-object" class="text-danger list-unstyled">
        <li v-for="(value, i) in datas" :key="i">
            {{ value.join("") }}
        </li>
    </ul>-->
</template>
<script>
export default {
    name: "error-handler",
    props: ["datas"]
};
</script>
