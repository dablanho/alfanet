<template>
    <div>
        <div class="col-12 p-0 col-sm-12">
            <router-link :to="{ name: 'CariDetay', params: { id: cari_id } }">
                <button class="btn mr-2 btn-sm btn-info">
                    <i class="fas fa-eye"></i> Genel Bilgiler
                </button>
            </router-link>
            <router-link :to="{ name: 'CariEkstre', params: { id: cari_id } }">
                <button class="btn mr-2 btn-sm btn-warning">
                    <i class="far fa-address-card"></i>
                    {{ $t("EKSTRE.EKSTRE") }}
                </button>
            </router-link>
            <router-link
                :to="{ name: 'CariCekSenetler', params: { id: cari_id } }"
            >
                <button class="btn mr-2 btn-sm btn-primary">
                    <i class="fas fa-scroll"></i>
                    {{ $t("CARI.CEKSENETLER") }}
                </button>
            </router-link>
            <router-link :to="{ name: 'OdemeAl', params: { id: cari_id } }">
                <button class="btn btn-sm btn-success">
                    <i class="fas fa-money-bill-wave"></i>
                    {{ $t("CARI.ODEME_AL") }}
                </button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "CariDetay",
    props: ["cari_id"]
};
</script>
