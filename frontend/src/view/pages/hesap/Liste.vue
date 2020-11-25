<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">{{ $t("HESAP.HESAPLAR") }}</h4>
                <router-link :to="{ name: 'HesapEkle' }">
                    <button class="btn btn-success float-right">
                        {{ $t("HESAP.DEFINITION") }}
                    </button>
                </router-link>
            </div>
            <Yukleyici v-if="getSpinner"></Yukleyici>
            <div v-else class="col-12 p-0 d-flex flex-wrap">
                <div
                    v-for="(data, key) in getHesaplar"
                    :key="key"
                    class="p-4 col-lg-4 col-md-6 col-sm-12"
                >
                    <div class="card-body bg-info position-relative rounded">
                        <!--<div class="position-absolute" style="right:5px;top:5px;">
              <button
                class="btn btn-sm btn-danger"
                :ref="'buton' + key"
                @click="sil(data.hesap.id, key)"
              >{{ $t("GENERAL.DELETE") }}</button>
            </div>-->
                        <router-link
                            :to="{
                                name: 'HesapDetay',
                                params: { id: data.hesap.id }
                            }"
                        >
                            <div
                                class="d-flex flex-column text-white align-items-start col-12"
                            >
                                <span>
                                    {{ $t("HESAP.HESAP_AD") }} :
                                    {{ data.hesap.hesap_ad }}
                                </span>
                                <span>
                                    {{ $t("HESAP.BANKA_AD") }} :
                                    {{ data.hesap.banka_ad }}
                                </span>
                                <span>
                                    {{ $t("HESAP.BAKIYE") }} :
                                    {{ data.hesap.bakiye
                                    }}{{ data.para_birimi.kod }}
                                </span>
                                <span>
                                    {{ $t("HESAP.PARA_BIRIMI") }} :
                                    {{ data.para_birimi.ad }}
                                </span>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body">
                <div >
                    <table
                        v-if="Object.keys(getHesaplar).length > 0"
                        class="table tabl-striped"
                    >
                        <tr>
                            <th>{{ $t("HESAP.HESAP_AD") }}</th>
                            <th>{{ $t("HESAP.BANKA_AD") }}</th>
                            <th>{{ $t("HESAP.BAKIYE") }}</th>
                            <th>{{ $t("HESAP.PARA_BIRIMI") }}</th>
                            <th>{{ $t("GENERAL.DETAILS") }}</th>
                            <th>{{ $t("GENERAL.DELETE") }}</th>
                            <th>{{ $t("GENERAL.UPDATE") }}</th>
                        </tr>
                        <tr
                            v-for="(data, key) in getHesaplar"
                            :key="key"
                        >
                            <td>{{ data.hesap.hesap_ad }}</td>
                            <td>{{ data.hesap.banka_ad }}</td>
                            <td>{{ data.hesap.bakiye }}</td>
                            <td>{{ data.para_birimi.kod }}</td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'HesapDetay',
                                        params: { id: data.hesap.id }
                                    }"
                                >
                                    <button class="btn btn-info">
                                        {{ $t("GENERAL.DETAILS") }}
                                    </button>
                                </router-link>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-danger"
                                    :ref="'buton' + key"
                                    @click="sil(data.hesap.id, key)"
                                >
                                    {{ $t("GENERAL.DELETE") }}
                                </button>
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'HesapDuzenle',
                                        params: { id: data.hesap.id }
                                    }"
                                >
                                    <button class="btn btn-sm btn-warning">
                                        {{ $t("GENERAL.UPDATE") }}
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                    </table>

                    <span v-else class="alert alert-sm alert-dark d-block">
                        {{ $t("GENERAL.NO_RECORD") }}
                    </span>
                </div>
                <Yukleyici v-else></Yukleyici>
      </div>-->
        </div>
    </div>
</template>

<script>
import { GET_HESAPLAR, DELETE_HESAP } from "@/core/services/store/hesap.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
export default {
    name: "HesapListe",
    computed: {
        ...mapGetters(["getHesaplar", "getSpinner"])
    },
    mounted() {
        this.$store.dispatch(GET_HESAPLAR);
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: this.$t("HESAP.HESAPLAR") }
        ]);
    },
    methods: {
        async sil(id, key) {
            const submitButton = this.$refs["buton" + key];

            submitButton[0].classList.add(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
            await this.$store
                .dispatch(DELETE_HESAP, id)
                .then(res => console.log(res.data.message));
            submitButton[0].classList.remove(
                "spinner",
                "spinner-light",
                "spinner-right"
            );
        }
    }
};
</script>
