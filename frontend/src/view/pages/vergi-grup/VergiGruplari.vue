<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("VERGIGRUP.GROUPS") }}</h4>
            </div>
            <Yukleyici v-if="getSpinner"></Yukleyici>
            <div v-else class="card-body">
                <table v-if="getVergiGruplari" class="table tabl-striped">
                    <tr>
                        <th>{{ $t("GENERAL.NAME") }}</th>
                        <th>{{ $t("VERGIGRUP.ORAN_YAZI") }}</th>
                        <th>{{ $t("GENERAL.DELETE") }}</th>
                        <th>{{ $t("GENERAL.UPDATE") }}</th>
                    </tr>
                    <tr v-for="(data, key) in getVergiGruplari" :key="key">
                        <td>{{ data.ad }}</td>
                        <td>{{ data.oran }}</td>
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
    GET_VERGIGRUPLARI,
    DELETE_VERGIGRUP
} from "@/core/services/store/vergi-grup.module";
import { mapGetters, mapActions } from "vuex";
export default {
    name: "VergiGruplari",

    computed: {
        ...mapGetters(["getVergiGruplari", "getSpinner"])
    },
    mounted() {
        this.$store.dispatch(GET_VERGIGRUPLARI);
    },
    methods: {
        ...mapActions({
            get_groups: GET_VERGIGRUPLARI,
            delete_group: DELETE_VERGIGRUP
        }),
        spinnerOperation(button, type) {
            button.classList[type]("spinner", "spinner-light", "spinner-right");
        },
        sil(id, key) {
            window.Swal.fire({
                title: this.$t("GENERAL.ARE_YOU_SURE"),
                text: this.$t("GENERAL.DELETE_PERMANENTLY"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: this.$t("GENERAL.YES"),
                cancelButtonText: this.$t("GENERAL.NO")
            }).then(result => {
                if (result.value) {
                    const submitButton = this.$refs["buton" + key][0];
                    this.spinnerOperation(submitButton, "add");
                    this.delete_group(id)
                        .then(() => {
                            // console.log(res.data.message);
                            this.spinnerOperation(submitButton, "remove");
                        })
                        .catch(err => {
                            console.log(err);
                            this.spinnerOperation(submitButton, "remove");
                        });
                }
            });
        },
        duzenle(id, ad, key) {
            this.$emit("vergiGruplariUpdate", { id, ad, key });
        }
    }
};
</script>
