<template>
    <!--begin::Mixed Widget 1-->
    <div class="card card-custom bg-gray-100 card-stretch gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 bg-danger py-5">
            <h3 class="card-title font-weight-bolder text-white">
                Ödeme Tablosu
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body p-0 position-relative overflow-hidden">
            <!--begin::Chart-->
            <apexchart
                class="card-rounded-bottom bg-danger"
                :options="chartOptions"
                :series="
                    fetchGeneralStatistics
                        ? fetchGeneralStatistics.bu_ay_alinan_odemeler_chart
                        : series
                "
                type="area"
            ></apexchart>
            <!--end::Chart-->
            <!--begin::Stats-->
            <div class="card-spacer mt-5">
                <!--begin::Row-->
                <div class="row m-0">
                    <div
                        class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7"
                    >
                        <span
                            class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"
                        >
                            <inline-svg
                                src="media/svg/icons/Communication/Group.svg"
                            />
                        </span>
                        <router-link
                            to="/ogrenciler"
                            class="text-warning font-weight-bold font-size-h6"
                        >
                            Öğrenciler ({{
                                fetchGeneralStatistics &&
                                    fetchGeneralStatistics.ogrenci_sayisi
                            }})
                        </router-link>
                    </div>
                    <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                        <span
                            class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"
                        >
                            <inline-svg src="media/svg/icons/Cars/bus.svg" />
                        </span>
                        <router-link
                            to="/araclar"
                            class="text-primary font-weight-bold font-size-h6 mt-2"
                        >
                            Araçlar ({{
                                fetchGeneralStatistics &&
                                    fetchGeneralStatistics.servis_sayisi
                            }})
                        </router-link>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row m-0">
                    <div
                        class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7"
                    >
                        <span
                            class="svg-icon svg-icon-3x svg-icon-warning d-block my-2"
                        >
                            <inline-svg
                                src="media/svg/icons/Communication/Group.svg"
                            />
                        </span>
                        <router-link
                            to="/hostesler"
                            class="text-warning font-weight-bold font-size-h6"
                        >
                            Hostesler ({{
                                fetchGeneralStatistics &&
                                    fetchGeneralStatistics.hostes_sayisi
                            }})
                        </router-link>
                    </div>
                    <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                        <span
                            class="svg-icon svg-icon-3x svg-icon-primary d-block my-2"
                        >
                            <inline-svg
                                src="media/svg/icons/Communication/Group.svg"
                            />
                        </span>
                        <router-link
                            to="/soforler"
                            class="text-primary font-weight-bold font-size-h6 mt-2"
                        >
                            Şoförler ({{
                                fetchGeneralStatistics &&
                                    fetchGeneralStatistics.sofor_sayisi
                            }})
                        </router-link>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row m-0">
                    <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                        <span
                            class="svg-icon svg-icon-3x svg-icon-danger d-block my-2"
                        >
                            <inline-svg
                                src="media/svg/icons/Shopping/Money.svg"
                            />
                        </span>
                        <a
                            href="#"
                            class="text-danger font-weight-bold font-size-h6 mt-2"
                        >
                            Bu Ay Kalan Ödemeler
                            <span
                                v-for="(data,
                                idx) in fetchGeneralStatistics.bu_ay_kalan_odemeler"
                                :key="idx"
                                ><br />{{ data }}</span
                            >
                        </a>
                    </div>
                    <div class="col bg-light-success px-6 py-8 rounded-xl">
                        <span
                            class="svg-icon svg-icon-3x svg-icon-success d-block my-2"
                        >
                            <inline-svg
                                src="media/svg/icons/Shopping/ATM.svg"
                            />
                        </span>
                        <a
                            href="#"
                            class="text-success font-weight-bold font-size-h6 mt-2"
                        >
                            Bu Ay Alınan Ödemeler
                            <span
                                v-for="(data,
                                idx) in fetchGeneralStatistics.bu_ay_alinan_odemeler"
                                :key="idx"
                                ><br />{{ data }}</span
                            >
                        </a>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Stats-->
            <!--end::Body-->
        </div>
        <!--end::Mixed Widget 1-->
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { FETCH_GENERAL_STATS } from "@/core/services/store/statistic.module";

export default {
    name: "widget-1",
    components: {},
    data() {
        return {
            strokeColor: "#E6283C",
            strokeColor2: "#148708",
            chartOptions: {},
            series: [
                {
                    name: "Alınan Ödeme TL",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: "Alınan Ödeme USD",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                }
            ]
        };
    },
    methods: {
        ...mapActions({
            fetch_lengths: FETCH_GENERAL_STATS
        })
    },
    computed: {
        ...mapGetters(["layoutConfig", "fetchGeneralStatistics"])
    },
    mounted() {
        // reference; kt_mixed_widget_1_chart
        this.chartOptions = {
            chart: {
                type: "area",
                height: 200,
                toolbar: {
                    show: true,
                    tools: {
                        customIcons: []
                    }
                },
                zoom: {
                    enabled: false
                },
                sparkline: {
                    enabled: true
                },
                dropShadow: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    top: 5,
                    left: 0,
                    blur: 3,
                    color: this.strokeColor,
                    opacity: 0.5
                }
            },
            plotOptions: {},
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: "solid",
                opacity: 0.5
            },
            stroke: {
                curve: "smooth",
                show: true,
                width: 3,
                colors: [this.strokeColor, this.strokeColor2]
            },
            xaxis: {
                categories:
                    this.fetchGeneralStatistics &&
                    this.fetchGeneralStatistics.ay_gunler,
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                labels: {
                    show: false,
                    style: {
                        colors: this.layoutConfig("colors.gray.gray-500"),
                        fontSize: "12px",
                        fontFamily: this.layoutConfig("font-family")
                    }
                },
                crosshairs: {
                    show: false,
                    position: "front",
                    stroke: {
                        color: this.layoutConfig("colors.gray.gray-300"),
                        width: 1,
                        dashArray: 3
                    }
                }
            },
            yaxis: {
                min: 0,

                labels: {
                    show: false,
                    style: {
                        colors: this.layoutConfig("colors.gray.gray-500"),
                        fontSize: "12px",
                        fontFamily: this.layoutConfig("font-family")
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: "none",
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: "none",
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: "none",
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: "12px",
                    fontFamily: this.layoutConfig("font-family")
                },
                y: {
                    formatter: function(val) {
                        return val + "TL";
                    }
                },
                marker: {
                    show: true
                }
            },
            colors: ["#E6283C", "#6edb62", "#892887"],
            markers: {
                colors: [this.layoutConfig("colors.theme.light.danger")],
                strokeColor: [this.strokeColor],
                strokeWidth: 3
            },
            grid: {
                show: false,
                padding: {
                    left: 0,
                    right: 0
                }
            }
        };
        this.fetch_lengths().then(() => {
            this.series = this.fetchGeneralStatistics.bu_ay_alinan_odemeler_chart;
        });
    }
};
</script>
