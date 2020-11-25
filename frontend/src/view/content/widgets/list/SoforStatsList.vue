<template>
    <div class="card card-custom card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header align-items-center border-0 mt-4">
            <h3 class="card-title align-items-start flex-column">
                <span class="font-weight-bolder text-dark">
                    Şoförlerle İlgili Yaklaşan Tarihler
                </span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <perfect-scrollbar
            class="quick-search-wrapper scroll"
            style="max-height: 40vh; position: relative;"
            v-bind:options="{ suppressScrollX: true }"
        >
            <div class="card-body pt-4">
                <div class="timeline timeline-5 mt-3">
                    <p v-if="fetchSoforStatistics.length === 0">Veri Yok!</p>
                    <template
                        v-for="(item, i) in fetchSoforStatistics &&
                            fetchSoforStatistics.slice(0, 100)"
                    >
                        <!--begin::Item-->
                        <div
                            class="timeline-item align-items-start"
                            v-bind:key="i"
                        >
                            <!--begin::Label-->
                            <div
                                class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3"
                            >
                                {{ item.time }}
                            </div>
                            <!--end::Label-->

                            <!--begin::Badge-->
                            <div class="timeline-badge">
                                <i
                                    class="icon-xxl"
                                    v-bind:class="item.badge"
                                ></i>
                            </div>
                            <!--end::Badge-->

                            <!--begin::Text-->
                            <div class="timeline-content text-dark-50 d-flex">
                                <router-link :to="item.url ? item.url : '#'">
                                    <span
                                        v-bind:class="{
                                            'font-weight-bolder text-dark-75':
                                                item.bold
                                        }"
                                        v-html="`${item.name} - `"
                                    ></span>
                                </router-link>
                                <span
                                    v-bind:class="{
                                        'font-weight-bolder text-dark-75':
                                            item.bold
                                    }"
                                    v-html="item.desc"
                                ></span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <!--end::Item-->
                    </template>
                </div>
                <!--end: Items-->
            </div>
        </perfect-scrollbar>
        <!--end: Card Body-->
    </div>
    <!--end: Card-->
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { FETCH_SOFOR_STATS } from "@/core/services/store/statistic.module";

export default {
    name: "SoforStatsList",
    data() {
        return {
            scrollStyle: "overflow-y: scroll; height: 500px;",
            list: []
        };
    },
    methods: {
        ...mapActions({
            sofor_stats: FETCH_SOFOR_STATS
        })
    },
    computed: {
        ...mapGetters(["layoutConfig", "fetchSoforStatistics"])
    },
    mounted() {
        this.sofor_stats();
    }
};
</script>

<style scoped></style>
