<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4 v-if="getArac.arac">{{ getArac.arac.plaka }}</h4>
                <TopBtns :arac_id="arac_id"></TopBtns>
            </div>
            <div class="card-body" v-if="getArac.arac && !getSpinner">
                <div class="col-12 p-0 d-flex flex-wrap align-items-end">
                    <span class="col-12">
                        <h4>{{ $t("GENERAL.GENERAL") }}</h4>
                    </span>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.PLAKA')"
                            :value="getArac.arac.plaka"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.MODEL_YILI')"
                            :value="getArac.arac.model_yili"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.BRAND')"
                            :value="getArac.marka"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.MODEL')"
                            :value="getArac.model"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.SOFOR')"
                            :value="getArac.sofor"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.KOLTUK_SAYISI')"
                            :value="getArac.arac.koltuk_sayisi"
                        ></TitleValue>
                    </div>
                    <div class="float-left col-md-6 col-sm-12">
                        <TitleValue
                            :title="$t('CARS.STATUS')"
                            :value="
                                +getArac.arac.arac_durumu === 1
                                    ? $t('CARS.KIRA')
                                    : $t('CARS.OZMAL')
                            "
                        ></TitleValue>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ARAC } from "@/core/services/store/arac.module";
import { mapGetters } from "vuex";
import TopBtns from "./TopBtns";
import TitleValue from "@/view/layout/extras/TitleValue";
export default {
    name: "AracStandart",
    components: { TitleValue, TopBtns },
    props: ["arac_id"],
    data() {
        return {};
    },
    mounted() {
        this.$store.dispatch(GET_ARAC, this.arac_id);
    },
    computed: {
        ...mapGetters(["getArac", "getSpinner"])
    }
};
</script>
