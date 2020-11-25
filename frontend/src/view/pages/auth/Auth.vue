<template>
    <div class="d-flex flex-column flex-root">
        <div
            class="d-flex bg-olive flex-column-fluid flex-center mt-30 mt-lg-0"
        >
            <router-view></router-view>

            <!--end::Content-->
        </div>

        <div class="anaFooter">
            <div>
                <a href="https://alfanet.com.tr">ALFANET © Copyright</a>
                <a href="https://alfalin.com.tr">Alfalin Yazılım</a>
            </div>
        </div>
    </div>
</template>

<!-- Load login custom page styles -->
<style lang="scss">
@import "@/assets/sass/pages/login/login-1.scss";
</style>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "auth",
    methods: {},
    mounted() {
        // check if current user is authenticated
        if (this.isAuthenticated) {
            this.$router.push({ name: "dashboard" });
        }
    },
    computed: {
        ...mapState({
            errors: state => state.auth.errors
        }),
        ...mapGetters(["isAuthenticated"])
    }
};
</script>
