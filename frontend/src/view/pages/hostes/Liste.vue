<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">{{ $t("HOSTES.HOSTESLER") }}</h4>
                <router-link :to="{ name: 'HostesEkle' }">
                    <button class="btn btn-success float-right">
                        {{ $t("HOSTES.DEFINITION") }}
                    </button>
                </router-link>
            </div>
            <div class="card-body">
                <BootstrapDataTable
                    :items="getHostesler"
                    :fields="fields"
                    :isBusy="isBusy"
                    :deleteAction="deleteAction"
                    editRouteName="HostesDuzenle"
                    detailsRouteName="HostesDetay"
                />
            </div>
            <!--<div class="card-body">
                <div v-if="getHostesler.data">
                    <table
                        v-if="Object.keys(getHostesler.data).length > 0"
                        class="table tabl-striped"
                    >
                        <tr>
                            <th>{{ $t("GENERAL.NAME") }}</th>
                            <th>{{ $t("GENERAL.PHONE_NUMBER") }}</th>
                            <th>{{ $t("MENU.SCHOOL") }}</th>
                            <th>{{ $t("GENERAL.DETAILS") }}</th>
                            <th>{{ $t("GENERAL.DELETE") }}</th>
                            <th>{{ $t("GENERAL.UPDATE") }}</th>
                        </tr>
                        <tr v-for="(data, key) in getHostesler.data" :key="key">
                            <td>{{ data.name }}</td>
                            <td>{{ data.telefon }}</td>
                            <td>{{ data.okul }}</td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'HostesDetay',
                                        params: { id: data.id }
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
                                    @click="sil(data.id, key)"
                                >
                                    {{ $t("GENERAL.DELETE") }}
                                </button>
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'HostesDuzenle',
                                        params: { id: data.id }
                                    }"
                                >
                                    <button class="btn btn-sm btn-warning">
                                        {{ $t("GENERAL.UPDATE") }}
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                    </table>

                    <span v-else class="alert alert-sm alert-dark d-block">{{
                        $t("GENERAL.NO_RECORD")
                    }}</span>
                </div>
                <Yukleyici v-else></Yukleyici>
            </div>-->
        </div>
    </div>
</template>

<script>
import {
    GET_HOSTESLER,
    DELETE_HOSTES
} from "@/core/services/store/hostes.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapGetters } from "vuex";
import BootstrapDataTable from "@/view/layout/extras/BootstrapDataTable";
export default {
    name: "HosteslerListe",
    components: { BootstrapDataTable },
    data() {
        return {
            fields: [
                {
                    key: "ad",
                    sortable: true,
                    label: "Hostes Adı"
                },
                {
                    key: "tel",
                    sortable: true,
                    label: "Telefon Numarası"
                },
                {
                    key: "okul",
                    sortable: true,
                    label: "Okul"
                },
                {
                    key: "actions",
                    label: "Actions"
                }
            ],
            isBusy: false,
            deleteAction: DELETE_HOSTES
        };
    },
    computed: {
        ...mapGetters(["getHostesler"])
    },
    mounted() {
        this.isBusy = !this.isBusy;
        this.$store
            .dispatch(GET_HOSTESLER)
            .then(() => (this.isBusy = !this.isBusy))
            .catch(() => (this.isBusy = !this.isBusy));
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: this.$t("HOSTES.HOSTESLER") }
        ]);
    },
    methods: {}
};
</script>
