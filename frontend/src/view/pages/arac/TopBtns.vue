<template>
    <div>
        <div class="col-12 p-0 col-sm-12 topBtns">
            <router-link :to="{ name: 'AracDetay', params: { id: arac_id } }">
                <button class="btn mr-2 btn-sm btn-secondary">
                    <i class="fas fa-eye"></i> Genel Bilgiler
                </button>
            </router-link>
            <router-link
                :to="{ name: 'AracOgrenciler', params: { id: arac_id } }"
            >
                <button class="btn mr-2 btn-sm btn-info">
                    <i class="fas fa-user-friends"></i>
                    Tüm Öğrenciler
                </button>
            </router-link>
            <button class="btn mr-2 btn-sm btn-purple">
                <i class="fas fa-star"></i>
                Puantaj Cetveli
            </button>
            <router-link
                :to="{ name: 'AracDosyaEkle', params: { id: arac_id } }"
            >
                <button class="btn mr-2 btn-sm btn-success">
                    <i class="far fa-file"></i>
                    Dosya Yükleme
                </button>
            </router-link>
            <button class="btn mr-2 btn-sm btn-green">
                <i class="fas fa-cash-register"></i>
                Hesaplar
            </button>
            <button class="btn mr-2 btn-sm btn-blue">
                <i class="far fa-money-bill-alt"></i>
                Hakedişler
            </button>
            <button class="btn mr-2 btn-sm btn-blue">
                <i class="fas fa-plus"></i>
                Hakediş Ekle
            </button>
            <button class="btn mr-2 btn-sm btn-pink">
                <i class="fas fa-money-bill-wave"></i>
                Ödeme Yap
            </button>
            <router-link :to="{ name: 'AracDuzenle', params: { id: arac_id } }">
                <button class="btn mr-2 btn-sm btn-warning edit">
                    <i class="fas fa-pen p-0 m-0"></i>
                </button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "TopBtns",
    props: ["arac_id"]
};
</script>
