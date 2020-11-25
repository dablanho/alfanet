<template>
    <div>
        <transition name="fadeAll" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
export default {
    name: "VeliIndex"
};
</script>
