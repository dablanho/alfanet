<template>
    <div>
        <div class="col-12 p-0 col-sm-12 topBtns">
            <router-link :to="{ name: 'OgrenciDetay', params: { id: ogr_id } }">
                <button class="btn mr-2 btn-sm btn-secondary">
                    <i class="fas fa-eye"></i> Genel Bilgiler
                </button>
            </router-link>
            <router-link :to="{ name: 'Sozlesmeler', params: { id: ogr_id } }">
                <button class="btn mr-2 btn-sm btn-blue">
                    <i class="far fa-address-card"></i>
                    Sözleşmeler
                </button>
            </router-link>
            <router-link :to="{ name: 'Makbuzlar', params: { id: ogr_id } }">
                <button class="btn mr-2 btn-sm btn-info">
                    <i class="far fa-file"></i>
                    Makbuzlar
                </button>
            </router-link>
            <button class="btn mr-2 btn-sm btn-success">
                <i class="far fa-file"></i>
                Faturalar
            </button>
            <router-link
                :to="{ name: 'OgrenciDosyaEkle', params: { id: ogr_id } }"
            >
                <button class="btn mr-2 btn-sm btn-danger">
                    <i class="far fa-file-archive"></i>
                    Dosyalar
                </button>
            </router-link>
            <router-link
                :to="{ name: 'OgrenciDuzenle', params: { id: ogr_id } }"
            >
                <button class="btn mr-2 btn-sm edit btn-warning">
                    <i class="far fa-edit edit"></i>
                </button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "OgrButtons",
    props: ["ogr_id"]
};
</script>
