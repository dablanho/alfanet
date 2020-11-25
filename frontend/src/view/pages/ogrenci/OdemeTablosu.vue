<template>
    <div>
        <div class="col-lg-6 p-0 mt-3 col-12 float-left">
            <div class="card">
                <div class="card-header">
                    <h4 class="float-left">Ödemeler</h4>
                    <button
                        class="btn btn-success btn-sm float-right"
                        @click="odemeAl"
                    >
                        Ödeme Al
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Ödeme Ayı</th>
                                <th>Toplam Ödeme</th>
                                <th>Yapılan Ödeme</th>
                                <th>Kalan Ödeme</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value1, key) in value" :key="key">
                                <td>{{ $t("AYLAR." + value1.ay) }}</td>
                                <td>{{ value1.tutar }}</td>
                                <td>{{ value1.odenen }}</td>
                                <td>{{ value1.kalan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 p-0 mt-3 pl-3 col-12 float-left">
            <transition name="fade">
                <div v-if="odemeAlAcik">
                    <OdemeAl @tamamlandi="odemeAlindi"></OdemeAl>
                </div>
            </transition>
        </div>
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Ödeme Al
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">...</div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Kapat
                        </button>
                        <button type="button" class="btn btn-primary">
                            Kaydet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import OdemeAl from "./OdemeAl";
export default {
    name: "OdemeTablosu",
    components: {
        OdemeAl
    },
    props: ["value"],
    data() {
        return {
            odemeAlAcik: false
        };
    },
    methods: {
        odemeAl() {
            this.odemeAlAcik = !this.odemeAlAcik;
        },
        odemeAlindi() {
            this.$emit("restartData", "1");
            this.odemeAlAcik = false;
        }
    }
};
</script>
