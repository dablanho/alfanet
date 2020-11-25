<template>
    <div>
        <Yukleyici v-if="getSpinner"></Yukleyici>
        <div v-else class="card">
            <div class="card-header">
                <h4>{{ getStaff.ad }}</h4>
            </div>
            <div class="card-body">
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Adı'"
                        :value="getStaff.ad"
                    ></TitleValue>
                </div>
                <div
                    class="float-left col-md-6 col-sm-12"
                    v-if="getStaff.hasOwnProperty('grup')"
                >
                    <TitleValue
                        :title="'Personel Grubu'"
                        :value="getStaff.grup.ad"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'E-Posta Adresi'"
                        :value="getStaff.email"
                    ></TitleValue>
                </div>
                <div
                    class="float-left col-md-6 col-sm-12"
                    v-if="getStaff.country"
                >
                    <TitleValue
                        :title="'Ülke'"
                        :value="getStaff.country.name"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12" v-if="getStaff.city">
                    <TitleValue
                        :title="'Şehir'"
                        :value="getStaff.city.name"
                    ></TitleValue>
                </div>
                <div
                    class="float-left col-md-6 col-sm-12"
                    v-if="getStaff.district"
                >
                    <TitleValue
                        :title="'İlçe'"
                        :value="getStaff.district.ilce"
                    ></TitleValue>
                </div>
                <div
                    class="float-left col-md-6 col-sm-12"
                    v-if="getStaff.street"
                >
                    <TitleValue
                        :title="'Mahalle'"
                        :value="getStaff.street.mahalle"
                    ></TitleValue>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_STAFF } from "@/core/services/store/personel.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "PersonelDetay",
    components: { TitleValue },
    data() {
        return {};
    },
    methods: {
        ...mapActions({ get_staff: GET_STAFF, set_breadcrumb: SET_BREADCRUMB })
    },
    mounted() {
        this.get_staff(this.$route.params.id);
        this.set_breadcrumb([
            { route: "/personeller", title: "Personeller" },
            { title: "Personel Detay" }
        ]);
    },
    computed: {
        ...mapGetters(["getStaff", "getSpinner"])
    }
};
</script>
