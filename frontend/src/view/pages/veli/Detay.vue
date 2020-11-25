<template>
    <div>
        <Yukleyici v-if="getSpinner"></Yukleyici>
        <div v-else class="card">
            <div class="card-header">
                <h4>{{ getVeli.ad }}</h4>
            </div>
            <div class="card-body">
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue :title="'Adı'" :value="getVeli.ad"></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Telefon Numarası'"
                        :value="getVeli.telefon"
                    ></TitleValue>
                </div>
                <div class="float-left col-md-6 col-sm-12">
                    <TitleValue
                        :title="'Yakınlık Derecesi'"
                        :value="getVeli.yakinlik"
                    ></TitleValue>
                </div>

                <div class="mt-5 col-12 float-left">
                    <h6>Veliye Bağlı Olan Öğrenciler</h6>
                    <table
                        class="table mt-5 border table-bordered table-hover table-striped"
                    >
                        <thead>
                            <tr>
                                <th>Öğrencinin Adı</th>
                                <th>Bulunduğu okul</th>
                                <th>Telefon</th>
                                <th>Adres</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(value, key) in getVeli.ogrenciler"
                                :key="key"
                            >
                                <td>{{ value.name }}</td>
                                <td>{{ value.okul }}</td>
                                <td v-if="value.telefon">
                                    {{ value.telefon }}
                                </td>
                                <td v-else>-</td>
                                <td>
                                    {{ value.city }}/{{ value.district }}/{{
                                        value.street
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_VELI } from "@/core/services/store/veli.module";
import { mapGetters } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "VeliDetay",
    components: { TitleValue },
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch(GET_VELI, this.$route.params.id);
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/veliler", title: "Veliler" },
            { title: "Veli Detay" }
        ]);
    },
    computed: {
        ...mapGetters(["getVeli", "getSpinner"])
    }
};
</script>
