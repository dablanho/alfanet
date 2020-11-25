<template>
    <div>
        <AracStandart :arac_id="$route.params.id"></AracStandart>
        <div v-if="!getSpinner && getArac.arac" class="card">
            <div class="card-body" v-if="!getSpinner">
                <div class="col-12 p-0 d-flex flex-wrap align-items-end">
                    <div class="col-12 mt-5 pt-5">
                        <h4 class="mt-3">{{ $t("CARS.STUDENTS") }}</h4>
                    </div>
                    <table
                        v-if="getArac.ogrenciler.length > 0"
                        class="table tabl-striped"
                    >
                        <tr>
                            <th>{{ $t("GENERAL.NAME") }}</th>
                            <th>{{ $t("GENERAL.PHONE_NUMBER") }}</th>
                            <th>{{ $t("MENU.SCHOOL") }}</th>
                            <th>{{ $t("STUDENT.PLACE") }}</th>
                            <th>{{ $t("GENERAL.DETAILS") }}</th>
                        </tr>
                        <tr
                            v-for="(data, key) in getArac.ogrenciler"
                            :key="key"
                        >
                            <td>{{ data.ad }}</td>
                            <td>{{ data.telefon }}</td>
                            <td>{{ data.okul.ad }}</td>
                            <td>
                                <span v-if="data.city != ''"
                                    >{{ data.city }}/{{ data.district }}</span
                                >
                                <span v-else>{{
                                    $t("GENERAL.NOT_DEFINED")
                                }}</span>
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'OgrenciDetay',
                                        params: { id: data.id }
                                    }"
                                >
                                    <button class="btn btn-info">
                                        {{ $t("GENERAL.DETAILS") }}
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                    </table>

                    <span v-else class="alert alert-sm alert-dark d-block">
                        {{ $t("GENERAL.NO_RECORD") }}
                    </span>
                </div>
            </div>
            <Yukleyici v-else></Yukleyici>
        </div>
        <Yukleyici v-else></Yukleyici>
    </div>
</template>

<script>
import { GET_ARAC } from "@/core/services/store/arac.module";
import { mapGetters } from "vuex";
import AracStandart from "./AracStandart";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "AracOgrenciler",
    components: { AracStandart },
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch(GET_ARAC, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/araclar", title: this.$t("CARS.CARS") },
            { title: this.$t("CARS.DETAIL") }
        ]);
    },
    computed: {
        ...mapGetters(["getArac", "getSpinner"])
    }
};
</script>
