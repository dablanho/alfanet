<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("CARI_GRUP.GROUPS") }}</h4>
            </div>
            <Yukleyici v-if="getSpinner"></Yukleyici>
            <div v-else class="card-body">
                <table v-if="getCariGruplari.length" class="table tabl-striped">
                    <tr>
                        <th>{{ $t("GENERAL.NAME") }}</th>
                        <th>{{ $t("GENERAL.DELETE") }}</th>
                        <th>{{ $t("GENERAL.UPDATE") }}</th>
                    </tr>
                    <tr v-for="(data, key) in getCariGruplari" :key="key">
                        <td>{{ data.ad }}</td>
                        <td>
                            <button
                                class="btn btn-danger"
                                :ref="'buton' + key"
                                @click="sil(data.id, key)"
                            >
                                Sil
                            </button>
                        </td>
                        <td>
                            <button
                                class="btn btn-warning"
                                :ref="'buton' + key"
                                @click="duzenle(data.id, data.ad, key)"
                            >
                                {{ $t("GENERAL.UPDATE") }}
                            </button>
                        </td>
                    </tr>
                </table>

                <span v-else class="alert alert-sm alert-dark d-block">{{
                    $t("GENERAL.NO_RECORD")
                }}</span>
            </div>
        </div>
    </div>
</template>
<script>
import {
    GET_CARIGRUPLARI,
    DELETE_CARIGRUP
} from "@/core/services/store/carigrup.module";
import { mapGetters } from "vuex";
export default {
    name: "CariGruplari",
    computed: {
        ...mapGetters(["getCariGruplari", "getSpinner"])
    },
    mounted() {
        this.$store.dispatch(GET_CARIGRUPLARI);
    },
    methods: {
        async sil(id, key) {
            const submitButton = this.$refs["buton" + key];
            this.$Progress.start();
            submitButton[0].classList.add(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
            await this.$store.dispatch(DELETE_CARIGRUP, id).then(res => {
                console.log(res.data.message);
                window.Toast.fire({
                    icon: "success",
                    title: this.$t("REQUEST_MESSAGES.DELETE_MESSAGE")
                });
                this.$Progress.finish();
            });
            submitButton[0].classList.remove(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
        },
        duzenle(id, ad, key) {
            this.$emit("cariGruplariUpdate", { id, ad, key });
        }
    }
};
</script>
